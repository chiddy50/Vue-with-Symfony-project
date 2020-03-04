<template>
    <div class="row">
   
    </div>
</template>

<script>
import Axios from 'axios';
import { mapState, mapGetters, mapActions } from 'vuex';

export default {
    name: 'GroupSubject',
    data(){
        return{
            subject_id: '',
            group_id: ''
        }
    },
    
    computed:{
       
        ...mapState(['student_group', 'subjects', 'groupSubjects', 'groupSubjectLoad'])
    },
    methods:{
        
    }
}
</script>

<style scoped>

</style>