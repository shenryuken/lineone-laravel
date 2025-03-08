{{-- users/partials/wallet-info.blade.php --}}
<div class="bg-white dark:bg-navy-700 shadow-md rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4 border-b pb-2">
        Wallet Information
    </h2>
    @foreach($user->wallets as $wallet)
    <div class="bg-slate-50 dark:bg-navy-600 p-4 rounded-lg mb-4">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="font-semibold">
                    {{ $wallet->currency }} Wallet
                    @if($wallet->is_default)
                    <span class="ml-2 px-2 py-1 bg-success/10 text-success text-xs rounded">
                        Default
                    </span>
                    @endif
                </h3>
                <p class="text-slate-500 dark:text-navy-100">
                    {{ $wallet->account_number }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-xl font-bold text-primary">
                    {{ number_format($wallet->balance / 100, 2) }} {{ $wallet->currency }}
                </p>
            </div>
        </div>
    </div>
    @endforeach
</div>
