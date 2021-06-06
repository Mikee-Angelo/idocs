import AppForm from '../app-components/Form/AppForm';

Vue.component('gad-plan-list-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                gad_plans_id:  '' ,
                gad_issue_mandate:  '' ,
                cause_of_issue:  '' ,
                gad_statement_objective:  '' ,
                relevant_agencies:  '' ,
                gad_activity:  '' ,
                indicator_target:  '' ,
                budget_requirement:  '' ,
                budget_source:  '' ,
                responsible_unit:  '' ,
                
            }
        }
    }

});