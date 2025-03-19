<?php

namespace App\Livewire\Wallets;

use Livewire\Component;
use App\Models\Wallet;
use App\Services\ToyyibPayService;
use App\Services\RediPayService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class Deposit extends Component
{
    // Form Fields
    public $amount = '';
    public $paymentMethod = 'stripe'; // Default to Stripe for testing
    public $wallet_id = null;
    public $wallet = null;

    // Preview and Confirmation Fields
    public $deposit_preview = false;
    public $deposit_confirmed = false;
    public $fee_amount = 0;
    public $net_amount = 0;

    // Result information
    public $showResult = false;
    public $isSuccess = false;
    public $resultMessage = '';
    public $resultDetails = [];
    public $messageTimeout = 10000; // 10 seconds for message display

    // Step tracking
    public $currentStep = 1;
    public $paymentUrl = null;

    protected $listeners = [
        'walletUpdated' => '$refresh'
    ];

    public function mount($wallet = null)
    {
        // Load user's default wallet or the provided wallet
        if ($wallet) {
            $this->wallet = $wallet;
        } else {
            $this->wallet = auth()->user()->wallet();
        }

        $this->wallet_id = $this->wallet->id;

        Log::info('Deposit component mounted', [
            'wallet_id' => $this->wallet_id,
            'user_id' => auth()->id()
        ]);
    }

    public function updatedAmount()
    {
        if (is_numeric($this->amount) && $this->amount > 0) {
            // Calculate 5% fee
            $this->fee_amount = round($this->amount * 0.05, 2);
            $this->net_amount = $this->amount - $this->fee_amount;
        } else {
            $this->fee_amount = 0;
            $this->net_amount = 0;
        }
    }

    public function nextStep()
    {
        if ($this->currentStep == 1) {
            $this->validate();
            $this->updatedAmount(); // Ensure fee calculation is up to date
            $this->currentStep = 2;

            Log::info('Moved to deposit preview step', [
                'wallet_id' => $this->wallet_id,
                'amount' => $this->amount,
                'fee' => $this->fee_amount
            ]);
        }
    }

    public function previousStep()
    {
        $this->currentStep = 1;
        $this->deposit_preview = false;

        Log::info('Returned to deposit amount step', [
            'wallet_id' => $this->wallet_id
        ]);
    }

    protected function rules()
    {
        return [
            'amount' => 'required|numeric|min:10',
            'paymentMethod' => 'required|in:redipay,stripe',
            'wallet_id' => 'required|exists:wallets,id'
        ];
    }

    protected $messages = [
        'amount.required' => 'Please enter an amount to deposit.',
        'amount.min' => 'Minimum deposit amount is 10.',
    ];

    // public function initiateDeposit()
    // {
    //     $this->validate();

    //     $user = Auth::user();
    //     $referenceNo = 'DEP-' . Str::random(10);

    //     try {
    //         Log::info('Initiating deposit', [
    //             'wallet_id' => $this->wallet_id,
    //             'amount' => $this->amount,
    //             'payment_method' => $this->paymentMethod
    //         ]);

    //         // Store the user ID in the session for later retrieval
    //         session(['payment_user_id' => $user->id]);

    //         if ($this->paymentMethod === 'toyyibpay') {
    //             $toyyibPay = new ToyyibPayService();

    //             // Convert amount to cents (ToyyibPay expects amount in cents)
    //             $amountInCents = (int)($this->amount * 100);

    //             $billData = [
    //                 'billName' => 'Wallet Deposit',
    //                 'billDescription' => 'Deposit to ' . $this->wallet->currency . ' Wallet',
    //                 'billPriceSetting' => 1,
    //                 'billPayorInfo' => 1,
    //                 'billAmount' => $amountInCents,
    //                 'billReturnUrl' => route('deposit.callback', ['wallet' => $this->wallet->id, 'method' => 'toyyibpay']),
    //                 'billCallbackUrl' => route('deposit.callback', ['wallet' => $this->wallet->id, 'method' => 'toyyibpay']),
    //                 'billExternalReferenceNo' => $referenceNo,
    //                 'billTo' => $user->name,
    //                 'billEmail' => $user->email,
    //                 'billPhone' => $user->phone ?? '0123456789',
    //             ];

    //             $response = $toyyibPay->createBill($billData);

    //             if ($response->successful()) {
    //                 $responseData = $response->json();
    //                 Log::info('ToyyibPay response', ['data' => $responseData]);

    //                 if (is_array($responseData) && !empty($responseData) && isset($responseData[0]['BillCode'])) {
    //                     // Construct payment URL using BillCode
    //                     $billCode = $responseData[0]['BillCode'];
    //                     $baseUrl = config('toyyibpay.base_url');
    //                     $this->paymentUrl = "{$baseUrl}/{$billCode}";

    //                     Log::info('Payment URL constructed', ['url' => $this->paymentUrl]);

    //                     return redirect()->to($this->paymentUrl);
    //                 } else {
    //                     Log::error('ToyyibPay: Invalid response format', ['response' => $responseData]);
    //                     $this->showErrorResult('Failed to create payment. Please try again.');
    //                     return;
    //                 }
    //             } else {
    //                 Log::error('ToyyibPay: API request failed', [
    //                     'status' => $response->status(),
    //                     'body' => $response->body()
    //                 ]);
    //                 $this->showErrorResult('Failed to create payment. Please try again.');
    //                 return;
    //             }
    //         } elseif ($this->paymentMethod === 'redipay') {
    //             try {
    //                 $rediPay = new RediPayService();

    //                 // Store user ID in session before redirecting
    //                 session(['payment_user_id' => $user->id]);
    //                 session(['payment_wallet_id' => $this->wallet_id]);

    //                 // Use the dedicated RediPay callback route
    //                 $callbackUrl = route('redipay.callback');

    //                 // Make sure the URL is absolute
    //                 Log::info('RediPay callback URL', ['url' => $callbackUrl]);

    //                 // Use the dedicated endpoints for RediPay
    //                 $paymentData = [
    //                     'amount' => number_format($this->amount, 2, '.', ''),
    //                     'email' => $user->email,
    //                     'item' => 'Wallet Deposit',
    //                     'name' => $user->name,
    //                     'callback_url' => $callbackUrl, // Server-to-server callback
    //                     'redirect_url' => $callbackUrl, // User browser redirect
    //                     'reference_no' => $referenceNo,
    //                     'wallet_id' => $this->wallet_id, // Include wallet ID in the reference
    //                     'user_id' => $user->id, // Include user ID in the payment data
    //                 ];

    //                 Log::info('Attempting RediPay payment creation', $paymentData);

    //                 $response = $rediPay->createPayment($paymentData);

    //                 if (!isset($response['payment_url'])) {
    //                     Log::error('RediPay: Invalid response format', ['response' => $response]);
    //                     session()->flash('toast', [
    //                         'type' => 'error',
    //                         'message' => 'Payment gateway error: Missing payment URL'
    //                     ]);
    //                     return redirect()->route('dashboard');
    //                 }

    //                 $this->paymentUrl = $response['payment_url'];
    //                 Log::info('RediPay payment URL generated', ['url' => $this->paymentUrl]);

    //                 return redirect()->to($this->paymentUrl);
    //             } catch (\Exception $e) {
    //                 Log::error('RediPay: Payment creation failed', [
    //                     'error' => $e->getMessage(),
    //                     'trace' => $e->getTraceAsString()
    //                 ]);

    //                 session()->flash('toast', [
    //                     'type' => 'error',
    //                     'message' => 'Payment gateway error: ' . $e->getMessage()
    //                 ]);
    //                 return redirect()->route('dashboard');
    //             }
    //         } elseif ($this->paymentMethod === 'stripe') {
    //                     // For Stripe, we'll redirect to our dedicated controller
    //                     return redirect()->route('stripe.checkout', [
    //                         'amount' => $this->amount,
    //                         'wallet_id' => $this->wallet_id
    //                     ]);
    //                 }
    //     } catch (\Exception $e) {
    //                 Log::error('Payment initiation failed', [
    //                     'error' => $e->getMessage(),
    //                     'trace' => $e->getTraceAsString(),
    //                     'method' => $this->paymentMethod
    //                 ]);
    //         $this->showErrorResult('An error occurred while processing your request. Please try again.');
    //     }
    // }

    public function initiateDeposit()
    {
        $this->validate();

        $user = Auth::user();
        $referenceNo = 'DEP-' . Str::random(10);

        try {
            Log::info('Initiating deposit', [
                'wallet_id' => $this->wallet_id,
                'amount' => $this->amount,
                'payment_method' => $this->paymentMethod
            ]);

            // Store the user ID in the session for later retrieval
            session(['payment_user_id' => $user->id]);

            if ($this->paymentMethod === 'redipay') {
                try {
                    $rediPay = new RediPayService();

                    // Store user ID in session before redirecting
                    session(['payment_user_id' => $user->id]);
                    session(['payment_wallet_id' => $this->wallet_id]);

                    // Use the dedicated RediPay callback route
                    $callbackUrl = route('redipay.callback');

                    // Make sure the URL is absolute
                    Log::info('RediPay callback URL', ['url' => $callbackUrl]);

                    // Use the dedicated endpoints for RediPay
                    $paymentData = [
                        'amount' => number_format($this->amount, 2, '.', ''),
                        'email' => $user->email,
                        'item' => 'Wallet Deposit',
                        'name' => $user->name,
                        'callback_url' => route('redipay.callback'), // Server-to-server callback
                        'redirect_url' => route('redipay.callback'), // Success page after payment
                        'reference_no' => $referenceNo,
                        'wallet_id' => $this->wallet_id, // Include wallet ID in the reference
                        'user_id' => $user->id, // Include user ID in the payment data
                    ];

                    Log::info('Attempting RediPay payment creation', $paymentData);

                    $response = $rediPay->createPayment($paymentData);

                    if (!isset($response['payment_url'])) {
                        Log::error('RediPay: Invalid response format', ['response' => $response]);
                        session()->flash('toast', [
                            'type' => 'error',
                            'message' => 'Payment gateway error: Missing payment URL'
                        ]);
                        return redirect()->route('dashboard');
                    }

                    $this->paymentUrl = $response['payment_url'];
                    Log::info('RediPay payment URL generated', ['url' => $this->paymentUrl]);

                    return redirect()->to($this->paymentUrl);
                } catch (\Exception $e) {
                    Log::error('RediPay: Payment creation failed', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);

                    session()->flash('toast', [
                        'type' => 'error',
                        'message' => 'Payment gateway error: ' . $e->getMessage()
                    ]);
                    return redirect()->route('dashboard');
                }
            } elseif ($this->paymentMethod === 'stripe') {
                // For Stripe, we'll redirect to our dedicated controller
                return redirect()->route('stripe.checkout', [
                    'amount' => $this->amount,
                    'wallet_id' => $this->wallet_id
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Payment initiation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'method' => $this->paymentMethod
            ]);
            $this->showErrorResult('An error occurred while processing your request. Please try again.');
        }
    }

    private function showErrorResult($message)
    {
        $this->isSuccess = false;
        $this->resultMessage = $message;
        $this->resultDetails = [];
        $this->showResult = true;
        $this->currentStep = 4;

        session()->flash('error', $message);
    }

    public function resetForm()
    {
        $this->reset([
            'amount',
            'paymentMethod',
            'deposit_preview',
            'deposit_confirmed',
            'fee_amount',
            'net_amount',
            'showResult',
            'isSuccess',
            'resultMessage',
            'resultDetails',
            'currentStep',
            'paymentUrl'
        ]);

        $this->currentStep = 1;

        Log::info('Deposit form reset', [
            'wallet_id' => $this->wallet_id,
            'user_id' => auth()->id()
        ]);
    }

    public function render()
    {
        // Get user's wallets for selection
        $userWallets = auth()->user()->wallets;

        return view('livewire.wallets.deposit', [
            'userWallets' => $userWallets
        ]);
    }
}

