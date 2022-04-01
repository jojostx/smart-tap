<div x-data="location_manager" class="mt-4">
  <input type="hidden" value="6.4333" name="latitude" x-ref="latitude" required>
  <input type="hidden" value="4.7434" name="longitude" x-ref="longitude" required>

  <x-button type="button" x-on:click="locate" x-bind:disabled="isLocating">
    <span class="relative flex w-3 h-3 mr-2">
      <span x-bind:class="{ 'animate-ping': isLocating }" class="absolute inline-flex w-full h-full bg-white rounded-full opacity-75"></span>
      <span class="relative inline-flex w-3 h-3 bg-white rounded-full"></span>
    </span>
    Get My Location
  </x-button>

  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('location_manager', () => ({
        geoId: null,
        isLocating: false,

        locate() {
          if (navigator.geolocation) {
            const geoId = navigator.geolocation.watchPosition(
              (position) => {
                if (position.coords.accuracy > 500) {
                  this.$dispatch('open-alert', {
                    message: "The GPS accuracy isn't good enough, go to an open space and try again",
                    alert_type: 'warning'
                  });
                } else {
                  this.$refs.latitude.value = position.coords.latitude;
                  this.$refs.longitude.value = position.coords.longitude;

                  this.$dispatch('open-alert', {
                    message: 'Your location was successfully detected',
                    alert_type: 'success'
                  });

                  this.stopLocating();
                }
              },

              (e) => {
                if (e.code !== 3) {
                  this.$dispatch('open-alert', {
                    message: 'An error occurred while acquiring your location, step outside and try again.',
                    alert_type: 'danger'
                  });
                }

                this.stopLocating();
              },

              {
                enableHighAccuracy: true,
                maximumAge: 10,
                timeout: 10000
              }
            );

            this.isLocating = true;

            this.geoId = geoId;
          }
        },

        stopLocating() {
          if (this.geoId !== null) {
            window.navigator.geolocation.clearWatch(this.geoId);

            this.isLocating = false;
          }
        },
      }))
    })
  </script>
</div>