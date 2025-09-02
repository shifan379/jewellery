<x-guest-layout>
    {{-- <x-authentication-card> --}}
    <x-slot name="logo">
        <x-authentication-card-logo />
    </x-slot>

    <x-validation-errors class="mb-4" />

    @session('status')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ $value }}
        </div>
    @endsession


    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="card">
            <div class="card-body p-5">
                <div class="login-userheading">
                    <h3>Sign In</h3>
                    <h4>Access the ZB POS panel using your email and password.</h4>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email" value="{{ __('Email') }}">Email <span class="text-danger">
                            *</span></label>
                    <div class="input-group">
                        <input id="email" type="email" name="email" :value="old('email')" required
                            autocomplete="username" class="form-control">
                        {{-- <span class="input-group-text border-start-0 ">
                            <i class="ti ti-mail"></i>
                        </span> --}}
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password" value="{{ __('Password') }}">Password <span
                            class="text-danger">
                            *</span></label>
                    <div class="pass-group">
                        <input type="password" class="pass-input form-control" id="password" name="password" required
                            autocomplete="current-password">
                        {{-- <span class="ti toggle-password ti-eye-off text-gray-9"></span> --}}
                    </div>
                </div>

                <div class="form-login authentication-check">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center justify-content-between">
                            <div class="custom-control custom-checkbox">
                                <label for="remember_me"
                                    class="checkboxs ps-4 mb-0 pb-0 line-height-1 fs-16 text-gray-6">
                                    <input type="checkbox" class="form-control">
                                    <span class="checkmarks" id="remember_me" name="remember"></span>
                                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                </label>
                                {{-- <label for="remember_me" class="flex items-center">
                                        <x-checkbox id="remember_me" name="remember" />
                                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                    </label> --}}
                            </div>
                            <div class="text-end">
                                @if (Route::has('password.request'))
                                    <a class="text-orange fs-16 fw-medium" href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                                {{-- <a class="text-orange fs-16 fw-medium" href="forgot-password.html">Forgot
                                        Password?</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-login">
                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </div>

            </div>
        </div>
    </form>
    {{--
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form> --}}
    {{-- </x-authentication-card> --}}
</x-guest-layout>
