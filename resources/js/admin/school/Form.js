import AppForm from '../app-components/Form/AppForm';

Vue.component('school-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                address:  '' ,
                admin_users_id:  '' ,
                status:  false ,
                
            }
        }
    }

});