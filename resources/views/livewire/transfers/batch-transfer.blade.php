<div>
    @if(session('success'))
    <div class="mb-4 rounded-lg bg-success px-4 py-3 text-white">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 rounded-lg bg-error px-4 py-3 text-white">
        {{ session('error') }}
    </div>
    @endif

    <div class="card">
        <div class="border-b border-slate-200 p-4 dark:border-navy-500 sm:px-5">
            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                Batch Transfer
            </h2>
            <p class="text-sm text-slate-500 dark:text-navy-300">
                Send money to multiple recipients at once
            </p>
        </div>

        <div class="p-4 sm:p-5">
            <!-- Source Wallet Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    From Wallet
                </label>
                <select wire:model="source_wallet_id"
                    class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2">
                    @foreach($userWallets as $wallet)
                    <option value="{{ $wallet->id }}">
                        {{ $wallet->currency }} Wallet ({{ number_format($wallet->balance/100, 2) }})
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- CSV Upload -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    Upload CSV File (Optional)
                </label>
                <input type="file" wire:model="csvFile" accept=".csv,.txt"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2">
                <p class="mt-1 text-xs text-slate-500">
                    CSV format: identifier,amount,description (identifier can be email, phone, or account number)
                </p>
                @if($csvFile)
                <button wire:click="processCsvFile" class="btn mt-2 bg-info text-white">
                    Process CSV
                </button>
                @endif
            </div>

            <!-- Manual Recipients -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-slate-700 dark:text-navy-100">Recipients</h3>
                    <button wire:click="addRecipient" class="btn bg-primary text-white">
                        Add Recipient
                    </button>
                </div>

                @foreach($recipients as $index => $recipient)
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-4 mb-4 p-4 border rounded-lg">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 dark:text-navy-100">
                            Email/Phone/Account
                        </label>
                        <input type="text" wire:model="recipients.{{ $index }}.identifier"
                            class="form-input mt-1 w-full rounded border border-slate-300 bg-white px-2 py-1">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 dark:text-navy-100">
                            Amount
                        </label>
                        <input type="number" wire:model="recipients.{{ $index }}.amount" step="0.01"
                            class="form-input mt-1 w-full rounded border border-slate-300 bg-white px-2 py-1">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 dark:text-navy-100">
                            Description
                        </label>
                        <input type="text" wire:model="recipients.{{ $index }}.description"
                            class="form-input mt-1 w-full rounded border border-slate-300 bg-white px-2 py-1">
                    </div>
                    <div class="flex items-end">
                        <button wire:click="removeRecipient({{ $index }})" class="btn bg-error text-white">
                            Remove
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    Batch Description
                </label>
                <textarea wire:model="description"
                    class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2"
                    rows="2"></textarea>
            </div>

            <!-- Actions -->
            <div class="flex space-x-4">
                @if(!$showPreview)
                <button wire:click="previewBatch" class="btn bg-info text-white">
                    Preview Batch
                </button>
                @else
                <button wire:click="processBatch" class="btn bg-success text-white">
                    Process Batch Transfer
                </button>
                <button wire:click="$set('showPreview', false)" class="btn border border-slate-300">
                    Edit
                </button>
                @endif
            </div>

            <!-- Preview -->
            @if($showPreview && count($recipients) > 0)
            <div class="mt-6 rounded-lg bg-slate-100 p-4 dark:bg-navy-600">
                <h3 class="text-lg font-medium mb-4">Batch Preview</h3>
                <div class="space-y-2">
                    @foreach($recipients as $recipient)
                    <div class="flex justify-between items-center p-2 bg-white rounded dark:bg-navy-700">
                        <span>{{ $recipient['identifier'] }}</span>
                        <span class="font-medium">{{ number_format($recipient['amount'], 2) }} MYR</span>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t">
                    <div class="flex justify-between font-semibold">
                        <span>Total Amount:</span>
                        <span>{{ number_format(collect($recipients)->sum('amount'), 2) }} MYR</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total Recipients:</span>
                        <span>{{ count($recipients) }}</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Recent Batches -->
    @if(count($recentBatches) > 0)
    <div class="card mt-6">
        <div class="border-b border-slate-200 p-4 dark:border-navy-500 sm:px-5">
            <h3 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                Recent Batch Transfers
            </h3>
        </div>
        <div class="p-4 sm:p-5">
            <div class="space-y-4">
                @foreach($recentBatches as $batch)
                <div class="flex justify-between items-center p-4 border rounded-lg">
                    <div>
                        <div class="font-medium">{{ $batch->batch_reference }}</div>
                        <div class="text-sm text-slate-500">
                            {{ $batch->created_at->format('M d, Y H:i') }}
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-medium">{{ number_format($batch->total_amount / 100, 2) }} MYR</div>
                        <div class="text-sm">
                            <span class="text-success">{{ $batch->successful_transfers }}</span> /
                            <span class="text-error">{{ $batch->failed_transfers }}</span> /
                            <span>{{ $batch->total_recipients }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
