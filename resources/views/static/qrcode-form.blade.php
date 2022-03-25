<x-guest-layout>
    <x-slot:title>
        Create QR Code
    </x-slot>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 text-gray-500 fill-current" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="flex items-center justify-center">
          <h1 class="text-lg font-medium">Create QR Code</h1>
        </div>

        <form method="POST" action="{{ route('qr-code') }}" class="mt-4">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <x-location-input/>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-3">
                    {{ __('Create') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
