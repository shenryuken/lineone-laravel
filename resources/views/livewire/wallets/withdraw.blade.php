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

    <div class="p-4">
        @if($currentStep == 1)
        <!-- Step 1: Withdrawal Details -->
        <div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    From Wallet
                </label>
                <select wire:model="source_wallet_id"
                    class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                    @foreach($userWallets as $wallet)
                    <option value="{{ $wallet->id }}">
                        {{ $wallet->currency }} Wallet ({{ number_format($wallet->balance/100, 2) }})
                    </option>
                    @endforeach
                </select>
                @error('source_wallet_id') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    Amount
                </label>
                <div class="relative mt-1.5">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500 dark:text-navy-200">
                        {{ $source_wallet ? $source_wallet->currency : 'MYR' }}
                    </span>
                    <input type="number" wire:model.live="amount"
                        class="form-input w-full rounded-lg border border-slate-300 bg-white pl-12 pr-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="0.00" step="0.01" min="10">
                </div>
                @error('amount') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            @if(is_numeric($amount) && $amount > 0)
            <div class="mb-4 p-3 bg-slate-100 dark:bg-navy-600 rounded-lg">
                <div class="flex justify-between mb-1">
                    <span class="text-slate-500 dark:text-navy-200">Amount:</span>
                    <span>{{ $source_wallet ? $source_wallet->currency : 'MYR' }} {{ number_format($amount, 2) }}</span>
                </div>
                <div class="flex justify-between mb-1">
                    <span class="text-slate-500 dark:text-navy-200">Fee (3%):</span>
                    <span>{{ $source_wallet ? $source_wallet->currency : 'MYR' }} {{ number_format($fee, 2) }}</span>
                </div>
                <div class="flex justify-between font-medium">
                    <span>Total Deduction:</span>
                    <span>{{ $source_wallet ? $source_wallet->currency : 'MYR' }} {{ number_format($totalDeduction, 2)
                        }}</span>
                </div>
            </div>
            @endif

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    Bank Name
                </label>
                <input type="text" wire:model="bank_name"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter bank name">
                @error('bank_name') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    Account Number
                </label>
                <input type="text" wire:model="account_number"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter account number">
                @error('account_number') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    Account Holder Name
                </label>
                <input type="text" wire:model="account_holder_name"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter account holder name">
                @error('account_holder_name') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    Description (Optional)
                </label>
                <textarea wire:model="description"
                    class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="What's this withdrawal for?" rows="2"></textarea>
                @error('description') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <button wire:click="nextStep"
                    class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    Continue
                </button>
            </div>
        </div>
        @elseif($currentStep == 2)
        <!-- Step 2: Confirm Withdrawal -->
        <div>
            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">Confirm Withdrawal</h3>

            <div class="rounded-lg bg-slate-100 p-4 dark:bg-navy-600 mb-4">
                <div class="flex justify-between mb-2">
                    <span class="text-slate-500 dark:text-navy-200">From:</span>
                    <span class="font-medium">{{ auth()->user()->name }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-slate-500 dark:text-navy-200">Amount:</span>
                    <span class="font-medium">{{ $source_wallet ? $source_wallet->currency : 'MYR' }} {{
                        number_format($amount, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-slate-500 dark:text-navy-200">Fee (3%):</span>
                    <span class="font-medium">{{ $source_wallet ? $source_wallet->currency : 'MYR' }} {{
                        number_format($fee, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2 font-medium">
                    <span class="text-slate-500 dark:text-navy-200">Total Deduction:</span>
                    <span class="font-medium">{{ $source_wallet ? $source_wallet->currency : 'MYR' }} {{
                        number_format($totalDeduction, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-slate-500 dark:text-navy-200">Bank Name:</span>
                    <span class="font-medium">{{ $bank_name }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-slate-500 dark:text-navy-200">Account Number:</span>
                    <span class="font-medium">{{ $account_number }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-slate-500 dark:text-navy-200">Account Holder:</span>
                    <span class="font-medium">{{ $account_holder_name }}</span>
                </div>
                @if($description)
                <div class="flex justify-between">
                    <span class="text-slate-500 dark:text-navy-200">Description:</span>
                    <span class="font-medium">{{ $description }}</span>
                </div>
                @endif
            </div>

            <div class="flex justify-between space-x-2">
                <button wire:click="previousStep"
                    class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                    Back
                </button>
                <button wire:click="confirmWithdraw"
                    class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    Confirm Withdrawal
                </button>
            </div>
        </div>
        @elseif($currentStep == 3)
        <!-- Step 3: Result -->
        <div class="text-center">
            @if($isSuccess)
            <div class="inline-flex size-16 items-center justify-center rounded-full bg-success/10 text-success mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-2">{{ $resultMessage }}</h3>

            <div class="mt-4 rounded-lg bg-slate-100 p-4 dark:bg-navy-600 mb-4 text-left">
                @foreach($resultDetails as $label => $value)
                <div class="flex justify-between mb-2">
                    <span class="text-slate-500 dark:text-navy-200">{{ $label }}:</span>
                    <span class="font-medium">{{ $value }}</span>
                </div>
                @endforeach
            </div>
            @else
            <div class="inline-flex size-16 items-center justify-center rounded-full bg-error/10 text-error mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-2">{{ $resultMessage }}</h3>

            @if(count($resultDetails) > 0)
            <div class="mt-4 rounded-lg bg-slate-100 p-4 dark:bg-navy-600 mb-4 text-left">
                @foreach($resultDetails as $label => $value)
                <div class="flex justify-between mb-2">
                    <span class="text-slate-500 dark:text-navy-200">{{ $label }}:</span>
                    <span class="font-medium">{{ $value }}</span>
                </div>
                @endforeach
            </div>
            @endif
            @endif

            <button wire:click="resetForm"
                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 mt-4">
                Make Another Withdrawal
            </button>
        </div>
        @endif
    </div>
</div>

