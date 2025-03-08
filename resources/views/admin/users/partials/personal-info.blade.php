{{-- users/partials/personal-info.blade.php --}}
<div class="bg-white dark:bg-navy-700 shadow-md rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4 border-b pb-2">
        Personal Information
    </h2>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-600 dark:text-navy-100">
                Full Name
            </label>
            <p class="mt-1">{{ $user->name }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-600 dark:text-navy-100">
                Email Address
            </label>
            <p class="mt-1">{{ $user->email }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-600 dark:text-navy-100">
                Phone Number
            </label>
            <p class="mt-1">
                {{ $user->profile->phone ?? 'Not provided' }}
            </p>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-600 dark:text-navy-100">
                Address
            </label>
            <p class="mt-1">
                {{ $user->profile->address ?? 'Not provided' }}
            </p>
        </div>
    </div>
</div>
