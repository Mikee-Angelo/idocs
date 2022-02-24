import AppForm from '../app-components/Form/AppForm';

Vue.component('liquidation-item-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                inputs: []
            },
            inputs: [
                {
                    item: ''
                }
            ]

        }
    },
    methods: {
        add(index) {
            this.inputs.push({ item: '' });
        },
        remove(index) {
            this.inputs.splice(index, 1);
        }
    },
});