<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-100 via-white to-indigo-100 px-4 py-10">
        <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 bg-white shadow-2xl rounded-3xl overflow-hidden">

            <!-- Left Side -->
            <div class="hidden md:flex flex-col justify-center bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white p-10">
                <div class="mb-6">
                    <x-authentication-card-logo />
                </div>

                <h1 class="text-4xl font-bold leading-tight mb-4">
                    Create Your Account
                </h1>

                <p class="text-white/90 text-lg leading-relaxed">
                    Join us today and get access to a smooth, secure, and modern dashboard experience.
                    Manage everything easily from one place.
                </p>

                <div class="mt-8 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">✓</div>
                        <span class="text-base">Simple and secure registration</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">✓</div>
                        <span class="text-base">Fast access to your dashboard</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">✓</div>
                        <span class="text-base">Clean and user-friendly experience</span>
                    </div>
                </div>
            </div>

            <!-- Right Side -->
            <div class="p-8 md:p-12">
                <div class="md:hidden flex justify-center mb-6">
                    <x-authentication-card-logo />
                </div>

                <div class="mb-8 text-center md:text-left">
                    <h2 class="text-3xl font-bold text-gray-800">Register</h2>
                    <p class="text-gray-500 mt-2">Please fill in the details to create your account.</p>
                </div>

                <x-validation-errors class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl" />

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-label for="name" value="{{ __('Name') }}" class="text-sm font-semibold text-gray-700 mb-1" />
                        <x-input
                            id="name"
                            class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                            type="text"
                            name="name"
                            :value="old('name')"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Enter your full name"
                        />
                    </div>

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" class="text-sm font-semibold text-gray-700 mb-1" />
                        <x-input
                            id="email"
                            class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autocomplete="username"
                            placeholder="Enter your email address"
                        />
                    </div>

                    <div>
                        <x-label for="password" value="{{ __('Password') }}" class="text-sm font-semibold text-gray-700 mb-1" />
                        <x-input
                            id="password"
                            class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Enter your password"
                        />
                    </div>

                    <div>
                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="text-sm font-semibold text-gray-700 mb-1" />
                        <x-input
                            id="password_confirmation"
                            class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Confirm your password"
                        />
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <x-checkbox name="terms" id="terms" required class="mt-1" />
                            <div class="text-sm text-gray-600 leading-relaxed">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="font-medium text-indigo-600 hover:text-indigo-800 underline">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="font-medium text-indigo-600 hover:text-indigo-800 underline">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    @endif

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 rounded-xl shadow-lg transition duration-300"
                        >
                            {{ __('Register') }}
                        </button>
                    </div>

                    <div class="text-center pt-2">
                        <a
                            class="text-sm text-gray-600 hover:text-indigo-600 transition"
                            href="{{ route('login') }}"
                        >
                            {{ __('Already registered? Login here') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>