import AppForm from '../app-components/Form/AppForm';

Vue.component('source-of-budget-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                
            }
        }
    }

});