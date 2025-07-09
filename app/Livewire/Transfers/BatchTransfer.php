<?php

namespace App\Livewire\Transfers;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\BatchTransfer;
use App\Models\User;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BatchTransfer extends Component
{
    use WithFileUploads;

    public $source_wallet_id;
    public $description = '';
    public $recipients = [];
    public $csvFile;
    public $showPreview = false;
    public $batchTransfer;

    protected $rules = [
        'source_wallet_id' => 'required|exists:wallets,id',
        'description' => 'nullable|string|max:255',
        'recipients.*.identifier' => 'required|string',
        'recipients.*.amount' => 'required|numeric|min:1',
        'recipients.*.description' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        // Check if user has permission for batch transfers
        if (!in_array(auth()->user()->role, ['admin', 'fund_manager', 'merchant'])) {
            abort(403, 'Unauthorized access to batch transfers.');
        }

        $this->source_wallet_id = auth()->user()->wallets->first()?->id;
    }

    public function addRecipient()
    {
        $this->recipients[] = [
            'identifier' => '',
            'amount' => '',
            'description' => '',
            'resolved_user' => null,
            'resolved_wallet' => null,
        ];
    }

    public function removeRecipient($index)
    {
        unset($this->recipients[$index]);
        $this->recipients = array_values($this->recipients);
    }

    public function processCsvFile()
    {
        $this->validate(['csvFile' => 'required|file|mimes:csv,txt']);

        $path = $this->csvFile->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data);

        $this->recipients = [];
        foreach ($data as $row) {
            if (count($row) >= 2) {
                $this->recipients[] = [
                    'identifier' => $row[0] ?? '',
                    'amount' => $row[1] ?? '',
                    'description' => $row[2] ?? '',
                    'resolved_user' => null,
                    'resolved_wallet' => null,
                ];
            }
        }

        $this->csvFile = null;
        session()->flash('success', 'CSV file processed successfully!');
    }

    public function previewBatch()
    {
        $this->validate();

        // Resolve recipients
        foreach ($this->recipients as &$recipient) {
            $user = $this->resolveUser($recipient['identifier']);
            if ($user) {
                $recipient['resolved_user'] = $user;
                $recipient['resolved_wallet'] = $user->wallets->first();
            }
        }

        $this->showPreview = true;
    }

    public function processBatch()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $sourceWallet = Wallet::findOrFail($this->source_wallet_id);
            $totalAmount = collect($this->recipients)->sum('amount');
            $totalAmountCents = (int)($totalAmount * 100);

            // Check sufficient balance
            if ($sourceWallet->balance < $totalAmountCents) {
                throw new \Exception('Insufficient funds for batch transfer.');
            }

            // Create batch transfer record
            $this->batchTransfer = BatchTransfer::create([
                'user_id' => auth()->id(),
                'wallet_id' => $this->source_wallet_id,
                'batch_reference' => BatchTransfer::generateBatchReference(),
                'total_amount' => $totalAmountCents,
                'total_recipients' => count($this->recipients),
                'description' => $this->description,
                'recipients' => $this->recipients,
                'status' => 'processing',
            ]);

            $walletService = new WalletService();
            $results = [];
            $successCount = 0;
            $failCount = 0;

            foreach ($this->recipients as $recipient) {
                try {
                    $user = $this->resolveUser($recipient['identifier']);
                    if (!$user || !$user->wallets->first()) {
                        throw new \Exception('Recipient not found or has no wallet');
                    }

                    $transfer = $walletService->transfer(
                        $sourceWallet,
                        $user->wallets->first(),
                        $recipient['amount'],
                        $recipient['description'] ?: $this->description
                    );

                    $results[] = [
                        'identifier' => $recipient['identifier'],
                        'amount' => $recipient['amount'],
                        'status' => 'success',
                        'transaction_id' => $transfer['withdraw']->id,
                    ];
                    $successCount++;

                } catch (\Exception $e) {
                    $results[] = [
                        'identifier' => $recipient['identifier'],
                        'amount' => $recipient['amount'],
                        'status' => 'failed',
                        'error' => $e->getMessage(),
                    ];
                    $failCount++;
                }
            }

            $this->batchTransfer->update([
                'successful_transfers' => $successCount,
                'failed_transfers' => $failCount,
                'status' => $failCount > 0 ? 'completed' : 'completed',
                'results' => $results,
                'processed_at' => now(),
            ]);

            DB::commit();

            session()->flash('success', "Batch transfer completed! {$successCount} successful, {$failCount} failed.");
            $this->reset(['recipients', 'description', 'showPreview']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Batch transfer failed', ['error' => $e->getMessage()]);
            session()->flash('error', 'Batch transfer failed: ' . $e->getMessage());
        }
    }

    private function resolveUser($identifier)
    {
        // Try to find by email, phone, or account number
        return User::where('email', $identifier)
            ->orWhere('phone', $identifier)
            ->orWhereHas('wallets', function($q) use ($identifier) {
                $q->where('account_number', $identifier);
            })
            ->first();
    }

    public function render()
    {
        $userWallets = auth()->user()->wallets;
        $recentBatches = BatchTransfer::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('livewire.transfers.batch-transfer', [
            'userWallets' => $userWallets,
            'recentBatches' => $recentBatches,
        ]);
    }
}
