<div>
    @if(session('success'))
    <div class="mb-4 rounded-lg bg-success px-4 py-3 text-white" x-data="{show: true}"
        x-init="setTimeout(() => { show = false }, {{ $messageTimeout }})" x-show="show"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 rounded-lg bg-error px-4 py-3 text-white" x-data="{show: true}"
        x-init="setTimeout(() => { show = false }, {{ $messageTimeout }})" x-show="show"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        {{ session('error') }}
    </div>
    @endif

    <div class="p-4">
        @if($currentStep == 1)
        <!-- Step 1: Deposit Details -->
        <div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    To Wallet
                </label>
                <select wire:model="wallet_id"
                    class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                    @foreach($userWallets as $userWallet)
                    <option value="{{ $userWallet->id }}">
                        {{ $userWallet->currency }} Wallet ({{ number_format($userWallet->balance/100, 2) }})
                    </option>
                    @endforeach
                </select>
                @error('wallet_id') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    Amount
                </label>
                <div class="relative mt-1.5">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500 dark:text-navy-200">
                        {{ $wallet ? $wallet->currency : 'MYR' }}
                    </span>
                    <input type="number" wire:model.live="amount"
                        class="form-input w-full rounded-lg border border-slate-300 bg-white pl-12 pr-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="0.00" step="0.01" min="10">
                </div>
                @error('amount') <span class="text-error text-sm">{{ $message }}</span> @enderror

                @if($amount && is_numeric($amount) && $amount > 0)
                <div class="mt-2 text-xs text-slate-500 dark:text-navy-300">
                    <div class="flex justify-between">
                        <span>Deposit Amount:</span>
                        <span>{{ $wallet->currency }} {{ number_format($amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Processing Fee (5%):</span>
                        <span class="text-error">- {{ $wallet->currency }} {{ number_format($fee_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-medium mt-1">
                        <span>Net Amount:</span>
                        <span>{{ $wallet->currency }} {{ number_format($net_amount, 2) }}</span>
                    </div>
                </div>
                @endif
            </div>

            {{-- <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    Payment Method
                </label>
                <div class="mt-1.5 grid grid-cols-3 gap-2">
                    <label
                        class="flex cursor-pointer items-center rounded-lg border border-slate-300 p-3 hover:border-slate-400 dark:border-navy-450 dark:hover:border-navy-400">
                        <input type="radio" wire:model="paymentMethod" value="toyyibpay"
                            class="form-radio mr-2 border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                        <span>ToyyibPay</span>
                    </label>
                    <label
                        class="flex cursor-pointer items-center rounded-lg border border-slate-300 p-3 hover:border-slate-400 dark:border-navy-450 dark:hover:border-navy-400">
                        <input type="radio" wire:model="paymentMethod" value="redipay"
                            class="form-radio mr-2 border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                        <span>RediPay</span>
                    </label>
                    <label
                        class="flex cursor-pointer items-center rounded-lg border border-slate-300 p-3 hover:border-slate-400 dark:border-navy-450 dark:hover:border-navy-400">
                        <input type="radio" wire:model="paymentMethod" value="stripe"
                            class="form-radio mr-2 border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                        <span>Stripe</span>
                    </label>
                </div>
                @error('paymentMethod') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div> --}}
            <div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                        Payment Method
                    </label>
                    <div class="mt-1.5 grid grid-cols-2 gap-3">
                        <label
                            class="flex cursor-pointer items-center rounded-lg border p-3 transition-all duration-200 ease-in-out
                            {{ $paymentMethod === 'redipay' ? 'border-primary bg-primary/10 dark:border-accent dark:bg-accent/10' : 'border-slate-300 hover:border-slate-400 dark:border-navy-450 dark:hover:border-navy-400' }}">
                            <input type="radio" wire:model.live="paymentMethod" value="redipay"
                                class="form-radio mr-2 border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary dark:text-accent-light"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="font-medium">RediPay</span>
                            </div>
                        </label>
                        <label
                            class="flex cursor-pointer items-center rounded-lg border p-3 transition-all duration-200 ease-in-out
                            {{ $paymentMethod === 'stripe' ? 'border-primary bg-primary/10 dark:border-accent dark:bg-accent/10' : 'border-slate-300 hover:border-slate-400 dark:border-navy-450 dark:hover:border-navy-400' }}">
                            <input type="radio" wire:model.live="paymentMethod" value="stripe"
                                class="form-radio mr-2 border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary dark:text-accent-light"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <path d="M1 10h22" />
                                </svg>
                                <span class="font-medium">Stripe</span>
                            </div>
                        </label>
                    </div>
                    @error('paymentMethod') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-2">
                <button wire:click="nextStep"
                    class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    Continue
                </button>
            </div>
        </div>
        @elseif($currentStep == 2)
        <!-- Step 2: Confirm Deposit -->
        <div>
            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">Confirm Deposit</h3>

            <div class="rounded-lg bg-slate-100 p-4 dark:bg-navy-600 mb-4">
                <div class="flex justify-between mb-2">
                    <span class="text-slate-500 dark:text-navy-200">To Wallet:</span>
                    <span class="font-medium">{{ $wallet->currency }} Wallet</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-slate-500 dark:text-navy-200">Amount:</span>
                    <span class="font-medium">{{ $wallet->currency }} {{ number_format($amount, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-slate-500 dark:text-navy-200">Processing Fee (5%):</span>
                    <span class="font-medium text-error">- {{ $wallet->currency }} {{ number_format($fee_amount, 2)
                        }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-slate-500 dark:text-navy-200">Net Amount:</span>
                    <span class="font-medium">{{ $wallet->currency }} {{ number_format($net_amount, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 dark:text-navy-200">Payment Method:</span>
                    <span class="font-medium">{{ ucfirst($paymentMethod) }}</span>
                </div>
            </div>

            <div class="flex justify-between space-x-2">
                <button wire:click="previousStep"
                    class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                    Back
                </button>

                @if($paymentMethod === 'stripe')
                <form action="{{ route('stripe.checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="amount" value="{{ $amount }}">
                    <input type="hidden" name="wallet_id" value="{{ $wallet_id }}">
                    <button type="submit"
                        class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        Proceed to Payment
                    </button>
                </form>
                @else
                <button wire:click="initiateDeposit"
                    class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    Proceed to Payment
                </button>
                @endif
            </div>
        </div>
        @elseif($currentStep == 4)
        <!-- Step 4: Success or Error Result -->
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
                Make Another Deposit
            </button>
        </div>
        @endif
    </div>
</div>
