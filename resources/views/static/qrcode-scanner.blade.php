<x-guest-layout>
    <x-slot:title>
      Scan QR Code
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
        <h1 class="text-lg font-medium">Scan QR Code</h1>
      </div>
      
      <div id="video-container" class="max-w-lg">
        <video id="qr-video"></video>
        <div style="position: absolute; display: none; pointer-events: none;" class="scan-region-highlight"><svg class="scan-region-highlight-svg" viewBox="0 0 238 238" preserveAspectRatio="none" style="position:absolute;width:100%;height:100%;left:0;top:0;fill:none;stroke:#e9b213;stroke-width:4;stroke-linecap:round;stroke-linejoin:round">
            <path d="M31 2H10a8 8 0 0 0-8 8v21M207 2h21a8 8 0 0 1 8 8v21m0 176v21a8 8 0 0 1-8 8h-21m-176 0H10a8 8 0 0 1-8-8v-21"></path>
          </svg><svg class="code-outline-highlight" preserveAspectRatio="none" style="display:none;width:100%;height:100%;fill:none;stroke:#e9b213;stroke-width:5;stroke-dasharray:25;stroke-linecap:round;stroke-linejoin:round">
            <polygon></polygon>
          </svg></div>
      </div>
      <div>
        <div>
          <p class="font-semibold text-gray-500">Scan from Camera: </p>
          <x-button id="start-button">Start</x-button>
        </div>
        <div class="mt-4">
          <p class="font-semibold text-gray-500">Detected QR code: </p>
          <span id="cam-qr-result">None</span>
        </div>
      </div>
      
      <div>
        <div>
          <p class="font-semibold text-gray-500">Scan from File: </p>
          <input type="file" id="file-selector">
        </div>
        <div class="mt-4">
          <p class="font-semibold text-gray-500">Detected QR code: </p>
          <span id="file-qr-result">None</span>
        </div>
      </div>
    </x-auth-card>

    @push('scripts')
     <script src="{{ asset('js/scanner.js') }}" defer></script> 
    @endpush
</x-guest-layout>