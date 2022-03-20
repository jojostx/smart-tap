<div x-data="location_manager" class="z-20 p-4 bg-red-500">
  <input type="hidden" name="latitude" x-ref="latitude" required>
  <input type="hidden" name="longitude" x-ref="longitude" required>

  <x-button type="button" x-on:click="locate">
    log it
  </x-button>

  <x-button type="button" x-on:click="stopLocating">
    cancel
  </x-button>

  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('location_manager', () => ({
        geoId: null,

        locate() {
          if (navigator.geolocation) {
            const geoId = navigator.geolocation.watchPosition(
              (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                if (position.coords.accuracy > 10) {
                  console.log("The GPS accuracy isn't good enough");
                } else {
                  this.$refs.latitude.value = lat;
                  this.$refs.longitude = lng;
                }
              },

              (e) => {
                console.log(e.message);
              },

              {
                enableHighAccuracy: true,
                maximumAge: 2000,
                timeout: 5000
              }
            );

            this.geoId = geoId;
          }
        },

        stopLocating() {
          if (this.geoId !== null) {
            console.log('Clear watch called: ' + this.geoId);
            window.navigator.geolocation.clearWatch(this.geoId);
          }

          this.$dispatch('open-toast', { message: 'Hello World!' });
        }
      }))
    })
  </script>
</div>