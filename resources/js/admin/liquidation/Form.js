import AppForm from '../app-components/Form/AppForm';

Vue.component('liquidation-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                purpose:  '' ,
                admin_users_id:  '' ,
                status:  false ,
                isSent:  false ,
                
            }
        }
    }

});