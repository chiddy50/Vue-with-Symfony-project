<template>
    <div class="row">
        <Header :title="'Students'" :title2="'Students'"/>

        <div class="col-sm-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>All Students</h3>
                        </div>
                        
                    </div>
                    <form class="mg-b-20" @submit.prevent="searchStudent($event)">
                        <div class="row gutters-8">
                            <div class="col-3-xxxl col-xl-4 col-lg-3 col-12 form-group">
                                <input type="text" @keyup="liveSearch($event)" id="searchStudent" v-model="name" placeholder="Search By Name or Roll No ..." class="form-control">
                            </div>
                            <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <select v-model="search.class_id" name="class_id" class="form-control rounded-0">
                                    <option disabled selected aria-selected>Select Class</option>                                                 
                                    <option v-for="oneClass in classes" :value="oneClass.id" :key="oneClass.id">
                                        {{ oneClass.class_name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <select v-model="search.section_id" name="section_id" class="form-control rounded-0">
                                    <option disabled selected aria-selected>Choose Section</option>
                                    <option v-for="section in sections" :key="section.id" :value="section.id">
                                        {{ section.section_name }}
                                    </option> 
                                </select>
                            </div>
                            <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table display data-table table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>                                    
                                    <th>Roll No</th>
                                    <th>Fullname</th>
                                    <th colspan="3"></th>
                                </tr>
                            </thead>
                            <tbody id="student-table-body" v-if="!studentsLoading">
                                <tr v-for="(student, index) in students" :key="student.id">                                    
                                    <td>{{ student.roll_no }}</td>
                                    <td>{{ student.firstname }} {{ student.lastname }}</td>
                                    <td class="text-center">
                                        <router-link :to="{ name: 'SingleStudent', params: { student } }" class="btn btn-lg shadow-dark-peel bg-warning rounded-bottom text-center text-light">
                                            <i class="fas fa-eye text-light"></i>
                                        </router-link>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-lg shadow-dark-peel bg-danger rounded-bottom text-light text-center" @click="deleteStudent(student.id, index, $event)">
                                            <i class="fas fa-trash text-light"></i>
                                        </button>
                                        <i class="fas fa-spinner fa-spin text-danger spinner-sm"></i>
                                    </td>
                                    <td class="text-center">
                                        <router-link :to="{ name: 'EditStudent', params: { student } }" class="btn btn-lg shadow-dark-peel bg-success text-center rounded-bottom text-light">
                                            <i class="fas fa-pencil-alt text-light"></i>
                                        </router-link>
                                    </td>                                     
                                </tr>                                
                            </tbody>
                            <tr v-else class="text-center">
                                <td>
                                    <i class="fas fa-spinner fa-spin text-danger spinner-md"></i>
                                </td>
                                <td>
                                    <i class="fas fa-spinner fa-spin text-danger spinner-md"></i>
                                </td>
                                <td>
                                    <i class="fas fa-spinner fa-spin text-danger spinner-md"></i>
                                </td>
                                <td>
                                    <i class="fas fa-spinner fa-spin text-danger spinner-md"></i>
                                </td>
                                <td>
                                    <i class="fas fa-spinner fa-spin text-danger spinner-md"></i>
                                </td>
                                
                            </tr>                        
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-sm-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>RESULT PROCESSING SHEET</h3>
                        </div>                        
                    </div>
                    <form class="mg-b-20">
                        <div class="row gutters-8">
                            <div class="col-3-xxxl col-xl-4 col-lg-3 col-12 form-group">
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <select class="form-control rounded-0">
                                    <option disabled selected aria-selected>Select Class</option>                                                 
                                    
                                </select>
                            </div>
                            <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <select id="section2" class="form-control rounded-0">
                                    <option disabled selected aria-selected>Choose Section</option>                                    
                                </select>
                            </div>
                            <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table display data-table table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>                                    
                                    <th>STUDENT NAME</th>
                                    <th colspan="5">ENGLISH</th>                                    
                                </tr>
                                <tr>                                    
                                    <th></th>
                                    <th>1ST C/A</th>
                                    <th>2ND C/A</th>
                                    <th>EXAM</th>
                                    <th>TOTAL</th>
                                    <th>GRADE</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                                             
                            </tbody>
                                                 
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>REPORT CARD FOR: MARK CANTU</h3>
                        </div>                        
                    </div>
                    <form class="mg-b-20">
                        <div class="row gutters-8">
                            <div class="col-4-md col-xl-3 col-lg-3 col-12 form-group">
                                <input type="text" disabled placeholder="Session" class="form-control">
                            </div>
                            <div class="col-4-md col-xl-3 col-lg-3 col-12 form-group">
                                <input type="text" disabled placeholder="Term" class="form-control">
                            </div>
                            <div class="col-4-md col-xl-3 col-lg-3 col-12 form-group">
                                <input type="text" disabled placeholder="Total Score" class="form-control">
                            </div>
                            <div class="col-4-md col-xl-3 col-lg-3 col-12 form-group">
                                <input type="text" disabled placeholder="Position" class="form-control">
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table display data-table table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>                                    
                                    <th>Subjects</th>
                                    <th>1st C/A</th>                                    
                                    <th>2nd C/A</th>                                    
                                    <th>Exam</th>                                    
                                    <th>Total</th>                                    
                                    <th>Remarks</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                                             
                            </tbody>
                                                 
                        </table>
                    </div>
                </div>
            </div>
        </div> -->


    </div>
</template>

<script>
import Axios from 'axios';
import { mapGetters, mapActions, mapState } from 'vuex';
import moment from 'moment';
import Datepicker from 'vuejs-datepicker';
import Header from '../inc/Header.vue';

export default {
    name: 'AllStudents',
    components:{
        Datepicker,
        Header
    },
    data(){
        return{
            studentDeleteLoading: false,
            name: null
        }
    },
    beforeMount(){
        this.getClasses(),
        this.fetchSections(),
        this.getGender(),
        this.getParents(),
        this.getGroups()
    },
    computed:{
    ...mapState(['sections', 'classes', 'parents', 'student_group', 'genders', 'students', 'studentsLoading', 'search']),
    },
    methods:{
        ...mapActions([ 'fetchSections', 'spliceStudent', 
                        'getGender', 'getClasses',
                        'searchStudent', 'getGroups',
                        'getParents'
                        ]),
        
        deleteStudent(id, index){
            this.studentDeleteLoading = true
            let formData = new FormData()
            formData.append('id', id)
            Axios.post("/deletestudent", formData)
            .then(response => {
                console.log(response)
                let res = response.data;
                this.$swal(res.message)
                this.studentDeleteLoading = false
                this.spliceStudent(index);
                $('#success').slideDown(500);
                setTimeout(() => {
                    $('#success').slideUp(500);
                }, 4000);   
                this.getStudents();
            })
            .catch(err => {
                console.log(err)
                this.studentDeleteLoading = false
            })
        },
        toggle(){
            $("#searchStudent").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#student-table-body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        },
        liveSearch(){
            this.$store.state.studentsLoading = true
            let formData = new FormData()
            formData.append('name', this.name)
            Axios.post("/live-search", formData)
            .then(response => {
                this.$store.state.studentsLoading = false
                let data = JSON.parse(response.data)
                console.log(data);
                
                if (data.error) {
                    Swal.fire('Error!', data.message, 'error')                    
                }else{            
                    this.$store.state.students = data.students;
                }                
            })
            .catch(err => {
                console.error(err)
            })
            .finally(() => this.$store.state.studentsLoading = false )
        } 
    }
}

    
</script>

<style scoped>
i.spinner-md{
    font-size: 30px;
}
i.spinner-sm{
    display: none !important;
}

</style>