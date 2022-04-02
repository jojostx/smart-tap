<x-guest-layout>
    <x-slot:title>
        View QR Code
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
          <h1 class="text-lg font-medium">QR Code</h1>
        </div>

        <div class="flex items-center justify-center p-4 mt-4">
            {!! $qrcode !!}
        </div>
    </x-auth-card>
</x-guest-layout>