<x-app-layout>
    <main class="flex flex-col  items-center space-y-4 justify-start pt-20 min-h-screen">
        <div class="flex items-center justify-center">
            <img src="{{ asset('images/logo.png') }}" class="h-20 w-auto" alt="Logo">
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('login') }}" class='border px-20 py-8 border-b-yellow-400 border-b-8 rounded-t-lg'>
            @csrf
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-white"/>
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="text-white" />
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center text-white" >
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span>
                </label>
            </div>
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-yellow-600 hover:text-yellow-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <x-primary-button class="ms-3 bg-yellow-500 text-black">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
            <p class="mt-4 text-center text-white">
                {{ __('No account yet?') }}
                <a class="text-yellow-600 hover:text-yellow-900" href="{{ route('register') }}">
                    {{ __('Create an account') }}
                </a>
            </p>


        </form>
    </main>
</x-app-layout>
