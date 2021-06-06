import AppForm from '../app-components/Form/AppForm';

Vue.component('reimbursement-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                letter_body:  '' ,
                admin_user_id:  '' ,
                status:  false ,
                
            }
        }
    }

});