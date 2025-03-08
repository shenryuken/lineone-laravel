{{-- users/partials/profile-header.blade.php --}}
<div class="bg-white dark:bg-navy-700 shadow-md rounded-lg p-6 flex items-center">
    <div class="mr-6">
        <img src="{{ $user->profile->avatar ?? asset('default-avatar.png') }}" alt="{{ $user->name }}"
            class="w-24 h-24 rounded-full object-cover">
    </div>
    <div>
        <h1 class="text-2xl font-bold text-slate-700 dark:text-navy-100">
            {{ $user->name }}
        </h1>
        <div class="flex items-center space-x-2 mt-2">
            <span class="px-3 py-1 rounded-full text-xs
                @if($user->status == 'active') bg-success/10 text-success
                @elseif($user->status == 'inactive') bg-warning/10 text-warning
                @else bg-error/10 text-error
                @endif
            ">
                {{ ucfirst($user->status) }}
            </span>
            <span class="text-slate-500 dark:text-navy-300">
                {{ $user->roles->first()->name ?? 'No Role' }}
            </span>
        </div>
    </div>
</div>
