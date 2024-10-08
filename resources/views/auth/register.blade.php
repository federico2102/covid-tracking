<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4"></x-jet-validation-errors>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}"></x-jet-label>
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"></x-jet-input>
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}"></x-jet-label>
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required></x-jet-input>
            </div>

            <div class="mt-4" hidden >
                <x-jet-label for="estado" value="{{ __('Estado') }}"></x-jet-label>
                <x-jet-input id="estado" class="block mt-1 w-full" type="string" name="estado" :value="old('estado')" value="No contagiado"></x-jet-input>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}"></x-jet-label>
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password"></x-jet-input>
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}"></x-jet-label>
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password"></x-jet-input>
            </div>

            <div class="mt-4" hidden >
                <x-jet-label for="locacion" value="{{ __('locacion') }}"></x-jet-label>
                <x-jet-input id="locacion" class="block mt-1 w-full" type="Integer" name="locacion" value="0"></x-jet-input>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ url('/') }}">
                    {{ __('Ya estas registrado?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Registrarse') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
