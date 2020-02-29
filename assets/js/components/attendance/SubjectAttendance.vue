<template>
    <div class="row">
        <Header :title="'Attendance'" :title2="'Subject Attendance'"/>

        <div class="col-lg-10 offset-1 col-sm-12">
            <div class="card dashboard-card-eleven">
                <div class="table-box-wrap">
                    <form @submit.prevent="searchStudent($event)" class="search-form-box">
                        <div class="row gutters-8">
                            <div class="col-lg-5 col-12 form-group">
                                <select v-model="form.class_id" class="form-control">
                                    <option disabled></option>
                                    <option :value="myclass.id" v-for="myclass in classes" :key="myclass.id">{{ myclass.class_name }}</option>
                                </select>
                            </div>
                            <div class="col-lg-5 col-12 form-group">
                                <select v-model="form.section_id" class="form-control">
                                    <option disabled></option>
                                    <option name="section_id" :value="section.id" v-for="section in sections" :key="section.id">{{ section.section_name }}</option>
                                </select>
                            </div>
                            
                            <div class="col-lg-2 col-12 form-group">
                                <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    

        <SubjectAttendanceTable/>

    </div>
</template>

<script>
import Axios from 'axios';
import Header from '../inc/Header.vue';
import { mapState, mapActions } from 'vuex';
import SubjectAttendanceTable from './components/SubjectAttendanceTable.vue';

export default {
    name: 'SubjectAttendance',
    components:{
        Header,
        SubjectAttendanceTable
    },
    data(){
        return{
            hideTable: true,
            form:{
                class_id: '',
                section_id: '',
                students: [],
                class_name: '',
                section_name: ''
            }
        }
    },
    mounted(){
        this.fetchSections(),
        this.getClasses()
    },
    computed:{
        ...mapState(['classes', 'sections']),
    },
    methods:{
        ...mapActions(['getClasses', 'fetchSections']),

        searchStudent(e){
            let formData = new FormData();
            formData.append('class_id', this.form.class_id);
            formData.append('section_id', this.form.section_id);
            Axios.post('/students-by-class', formData)
            .then(response => {
                this.hideTable = false
                let data = response.data;
                this.$store.state.filteredStudents = data.students[0];  
                this.class_name = data.class_name;
                this.section_name = data.section_name;
            })
            .catch(err => {
                console.error(err);                
            })
        },
    }
}
</script>

<style>

</style>