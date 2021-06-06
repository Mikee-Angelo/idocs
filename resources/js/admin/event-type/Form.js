import AppForm from '../app-components/Form/AppForm';

Vue.component('event-type-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                admin_user_id:  '' ,
                
            }
        }
    }

});