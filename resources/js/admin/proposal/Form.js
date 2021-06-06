import AppForm from '../app-components/Form/AppForm';

Vue.component('proposal-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                gad_plans_id:  '' ,
                letter_body:  '' ,
                proposal_body:  '' ,
                
            }
        }
    }

});