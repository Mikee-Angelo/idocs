import AppForm from '../app-components/Form/AppForm';

Vue.component('accomplishment-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                description:  '' ,
            },
            mediaCollections: ['gallery']
        }
    }

});