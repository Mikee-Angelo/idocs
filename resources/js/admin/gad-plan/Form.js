import AppForm from '../app-components/Form/AppForm';

Vue.component('gad-plan-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                role_id:  '' ,
                model_type:  '' ,
                model_id:  '' ,
                status:  false ,
                
            }
        }
    }

});