<template>
    <div class="row">
        <Header :title="'Search for Student by Class & Section'" :title2="'Student Mark Sheet'"/>

        <div class="col-lg-10 offset-1 col-sm-12">
            <div class="card dashboard-card-eleven">
                <div class="table-box-wrap">
                    <form @submit.prevent="searchStudent($event)" class="search-form-box">
                        <div class="row gutters-8">
                            <div class="col-lg-5 col-4 form-group">
                                <select v-model="form.class_id" class="form-control">
                                    <option aria-placeholder="Choose Class" selected disabled>Choose Class</option>
                                    <option :value="myclass.id" v-for="myclass in classes" :key="myclass.id" class="text-uppercase">{{ myclass.class_name }}</option>
                                </select>
                            </div>
                            <div class="col-lg-5 col-4 form-group">
                                <select v-model="form.section_id" class="form-control">
                                    <option aria-placeholder="Choose Section" selected disabled>Choose Section</option>
                                    <option name="section_id" :value="section.id" v-for="section in sections" :key="section.id" class="text-uppercase">{{ section.section_name }}</option>
                                </select>
                            </div>                            
                            <div class="col-lg-2 col-2 form-group">
                                <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-10 offset-1 col-sm-12" v-if="watchClassAndSectionLoading || searchStudentLoading">
            <div class="box">
                <h3 class="loading text-primary">Please wait....</h3>
            </div>
        </div>

        <StudentMarkSheetTable v-if="students.length" :students="students" :className="className" :sectionName="sectionName"/>
    </div>
</template>

<script>
import Axios from 'axios';
import Header from '../inc/Header.vue';
import StudentMarkSheetTable from './StudentMarkSheetTable.vue';
import { mapActions, mapState } from 'vuex';

export default{
    name: 'StudentMarkSheet',
    components:{
        Header,
        StudentMarkSheetTable
    },
    data(){
        return{
            searchStudentLoading: false,
            form:{
                class_id: '',
                section_id: ''
            },
            students: [],
            className: '',
            sectionName: ''
        }
    },
    mounted(){
        this.fetchSections(),
        this.getClasses()
    },
    computed:{
        ...mapState(['classes', 'sections']),
        watchClassAndSectionLoading(){
            return this.$store.state.classLoading === true || this.$store.state.sectionLoading === true ? true : false;
        }
    },
    methods:{
        ...mapActions(['getClasses', 'fetchSections', 'getTerms']),

        searchStudent(e){
            this.searchStudentLoading = true
            let formData = new FormData();
            formData.append('class_id', this.form.class_id);
            formData.append('section_id', this.form.section_id);
            Axios.post('/searchstudent', formData)
            .then(response => {
                this.searchStudentLoading = false                
                let data = JSON.parse(response.data);
                console.log(data);
                
                if (data.error) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }else{
                    this.students = data.students
                    this.className = data.class_name
                    this.sectionName = data.section_name
                }
            })
            .catch(err => console.error(err))
            .finally(() => this.searchStudentLoading = false)
        },
    }

}
</script>

<style scoped>
.box{
    display: flex;
    justify-content: center;
    align-items: center;   
}
</style>