import AppForm from '../app-components/Form/AppForm';

Vue.component('announcement-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                event_type_id:  '' ,
                header_img:  '' ,
                title:  '' ,
                description:  '' ,
                url:  '' ,
                starts_at:  '' ,
                ends_at:  '' ,
                created_by:  '' ,
                
            },
            mediaCollections: ['header']
        }
    }

});