<x-base-layout title="Login">
    <div class="fixed top-0 hidden p-6 lg:block lg:px-12">
        <a href="#" class="flex items-center space-x-2">
            <img class="text-l" width="300px" src="{{ asset('images/horizontal.png') }}" alt="logo" />
            {{-- <p class="text-xl font-semibold uppercase text-slate-700 dark:text-navy-100">
                {{ config('app.name') }}
            </p> --}}
        </a>
    </div>
    <div class="hidden w-full place-items-center lg:grid">
        <div class="w-full max-w-lg p-6">
            <img class="w-full" x-show="!$store.global.isDarkModeEnabled"
                src="{{ asset('images/illustrations/dashboard-check.svg') }}" alt="image" />
            <img class="w-full" x-show="$store.global.isDarkModeEnabled"
                src="{{ asset('images/illustrations/dashboard-check-dark.svg') }}" alt="image" />
        </div>
    </div>
    <main class="flex w-full flex-col items-center bg-white dark:bg-navy-700 lg:max-w-md">
        <div class="flex w-full max-w-md flex-col px-4">
            <div class="text-center">
                <img class="mx-auto h-16 w-16" src="{{ asset('images/app-logo.png') }}" alt="Logo" />
                <div class="mt-4">
                    <h2 class="text-2xl font-semibold text-slate-600 dark:text-navy-100">
                        Reset Password
                    </h2>
                    <p class="text-slate-400 dark:text-navy-300">
                        Create a new password for your account
                    </p>
                </div>
            </div>

            <div class="card mt-5 rounded-lg p-5 lg:p-7">
                @if (session('status'))
                <div class="mb-4 rounded-lg bg-success px-4 py-3 text-white">
                    {{ session('status') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-4 rounded-lg bg-error px-4 py-3 text-white">
                    @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="space-y-4">
                        <label class="block">
                            <span class="text-sm+ text-slate-600 dark:text-navy-100">Email</span>
                            <input name="email" value="{{ $email ?? old('email') }}"
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="Enter your email" type="email" />
                        </label>

                        <label class="block">
                            <span class="text-sm+ text-slate-600 dark:text-navy-100">New Password</span>
                            <input name="password"
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="New password" type="password" />
                        </label>

                        <label class="block">
                            <span class="text-sm+ text-slate-600 dark:text-navy-100">Confirm Password</span>
                            <input name="password_confirmation"
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="Confirm new password" type="password" />
                        </label>

                        <div class="mt-6">
                            <button type="submit"
                                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 w-full">
                                Reset Password
                            </button>
                        </div>

                        <div class="mt-4 text-center text-xs+">
                            <p class="line-clamp-1">
                                <span>Remember your password?</span>
                                <a href="{{ route('login') }}"
                                    class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">Back
                                    to login</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
