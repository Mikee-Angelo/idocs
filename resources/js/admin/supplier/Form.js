import AppForm from '../app-components/Form/AppForm';

Vue.component('supplier-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                added_by:  '' ,
                
            }
        }
    }

});