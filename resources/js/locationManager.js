export default () => ({
    init() {
        if (!navigator.geolocation) {
            console.log('not supported');
        }

        console.log('supported');
    },

    open: false,

    logIt() { console.log(this.$refs.locator) }
});