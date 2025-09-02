<x-guest-layout>
    {{-- <x-authentication-card> --}}
        <x-slot name="logo">
            {{-- <x-authentication-card-logo /> --}}
        </x-slot>


        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="card">
                <div class="card-body p-5">
                    <div class="login-userheading">
                        <h3>Forgot password?</h3>
                        <h4>If you forgot your password, well, then we’ll email you instructions to reset your password.
                        </h4>
                    </div>
                    <div class="mb-3">
                        <label for="email" value="{{ __('Email') }}" class="form-label">Email <span
                                class="text-danger"> *</span></label>
                        <div class="input-group">
                            <input class="form-control border-end-0" id="email"
                                type="email" name="email" :value="old('email')" required
                                autofocus autocomplete="username">
                            <span class="input-group-text">
                                <i class="ti ti-mail"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-login">
                        <button type="submit" class="btn btn-login">Sign Up</button>
                    </div>
                    <div class="signinform text-center">
                        <h4>Return to<a href="{{route('login')}}"> login </a></h4>
                    </div>

                </div>
            </div>
        </form>


        {{-- <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card> --}}
</x-guest-layout>
