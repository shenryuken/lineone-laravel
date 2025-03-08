{{-- users/partials/user-actions.blade.php --}}
<div class="bg-white dark:bg-navy-700 shadow-md rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4 border-b pb-2">
        Quick Actions
    </h2>
    <div class="space-y-3">
        <a href="{{ route('admin.users.edit', $user) }}" class="block w-full text-center py-2 px-4
                  bg-primary/10 text-primary
                  hover:bg-primary/20
                  rounded-lg transition">
            Edit Profile
        </a>
        @if($user->status != 'suspended')
        <button class="w-full py-2 px-4
                       bg-error/10 text-error
                       hover:bg-error/20
                       rounded-lg transition" onclick="confirmSuspend()">
            Suspend User
        </button>
        @endif
    </div>
</div>
