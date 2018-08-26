module.exports = {
    props: [
        'filters'
    ],

    data() {
        return {
            modalOpen: false,
        };
    },

    methods: {
        openModal() {
            this.modalOpen = true;
        },

        closeModal() {
            this.modalOpen = false;
        },

        filtered(payload) {
            this.$emit('filtered', payload);
        },

        selected(payload) {
            this.$emit('selected', payload)
        },
    }
}