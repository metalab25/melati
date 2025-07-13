<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Ganti Password</h2>
    </x-slot>

    <div class="max-w-xl py-12 mx-auto">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <div>
                <x-input-label for="current_password" :value="__('Password Lama')" />
                <x-text-input id="current_password" type="password" name="current_password" required autocomplete="current-password" class="block w-full mt-1"/>
                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Password Baru')" />
                <x-text-input id="password" type="password" name="password" required autocomplete="new-password" class="block w-full mt-1"/>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="block w-full mt-1"/>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-primary-button>{{ __('Simpan Password') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
