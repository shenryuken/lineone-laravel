{{-- users/partials/account-details.blade.php --}}
<div class="bg-white dark:bg-navy-700 shadow-md rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4 border-b pb-2">
        Account Details
    </h2>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-600 dark:text-navy-100">
                Registered At
            </label>
            <p class="mt-1">
                {{ $user->created_at->format('d M Y, H:i') }}
            </p>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-600 dark:text-navy-100">
                Last Login
            </label>
            <p class="mt-1">
                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
            </p>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-600 dark:text-navy-100">
                Roles
            </label>
            <div class="mt-1 space-x-2">
                @foreach($user->roles as $role)
                <span class="px-2 py-1 bg-primary/10 text-primary rounded-md text-xs">
                    {{ $role->name }}
                </span>
                @endforeach
            </div>
        </div>
    </div>
</div>
