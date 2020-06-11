<template>
    <div class="row">
        <Header :title="'Students'" :title2="'Class Processing Sheet'"/>

        <div class="col-md-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Search for students</h3>
                        </div>                        
                    </div>
                    
                    <form @submit.prevent="searchStudent($event)" class="new-added-form">
                        <div class="row">
                            <div class="col-6-xxxl col-lg-6 col-12 form-group">
                                <label>Choose Class</label>
                                <select v-model="form.class_id" class="form-control" name="class_id">
                                    <option aria-placeholder="Choose Class" selected disabled>Choose Class</option>
                                    <option :value="myclass.id" v-for="myclass in classes" :key="myclass.id">{{ myclass.class_name }}</option>
                                </select>
                            </div>
                            <div class="col-6-xxxl col-lg-6 col-12 form-group">
                                <label>Choose Section</label>
                                <select v-model="form.section_id" class="form-control" name="section_id">
                                    <option aria-placeholder="Choose Section" selected disabled>Choose Section</option>
                                    <option name="section_id" :value="section.id" v-for="section in sections" :key="section.id">{{ section.section_name }}</option>
                                </select>
                            </div>
                            
                            <div class="col-12 form-group mg-t-8">
                                <button :disabled="$store.state.studentsLoading" type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>RESULT PROCESSING SHEET</h3>
                        </div>                        
                    </div>
                    <form class="mg-b-20" @submit.prevent="processResults($event)">
                        <div class="row gutters-8">                            
                            <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <select class="form-control" name="session">
                                    <option disabled selected>Select Session</option>
                                    <option v-for="session in sessions" :key="session.id" :value="session.id">
                                        {{ session.session }}
                                    </option>                                        
                                </select>
                            </div>
                            <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <select class="form-control" name="term">
                                    <option disabled selected>Select Term</option>
                                    <option v-for="term in terms" :key="term.id" :value="term.id">
                                        {{ term.term_code }}
                                    </option>                                        
                                </select>
                            </div>
                            <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <input type="date" class="form-control" name="date"/>
                            </div>
                            
                            <div class="col-2-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                <button :disabled="recordLoad" type="submit" class="fw-btn-fill btn-gradient-yellow">RECORD</button>
                            </div>
                        </div>
                    
                        <div class="table-responsive">
                            <table class="table display data-table table-striped table-bordered text-nowrap">
                                <thead>
                                    <tr>                                    
                                        <th class="text-center">
                                            <i v-if="recordLoad" class="fas fa-spinner fa-spin text-danger spinner-md"></i>
                                        </th>
                                        <th colspan="2">
                                            <select name="subject" class="form-control select2">
                                                <option :value="subject.id" name="subject" v-for="(subject, index) in subjects" :key="index">{{ subject.subject }}</option>
                                            </select>                                    
                                        </th> 
                                        <th colspan="3"></th>                                   
                                    </tr>
                                    <tr>                                    
                                        <th>STUDENT NAME</th>
                                        <th>1ST C/A</th>
                                        <th>2ND C/A</th>
                                        <th>EXAM</th>
                                        <th>TOTAL</th>
                                        <th>GRADE</th>                                    
                                    </tr>
                                </thead>
                                <tbody v-if="!$store.state.studentsLoading">
                                    <tr v-for="(student, index) in students" :key="index">
                                        <td>{{ student.firstname }} {{ student.lastname }}</td>
                                        <td>
                                            <input type="number" :name="'first_ca['+[student.id]+']'" placeholder="1st C/A.." class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" :name="'second_ca['+[student.id]+']'" placeholder="2nd C/A.." class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" :name="'exam['+[student.id]+']'" placeholder="Exam.." class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" :name="'total['+[student.id]+']'" placeholder="Total.." class="form-control">
                                        </td>
                                        <td>
                                            <select class="form-control" :name="'grade['+[student.id]+']'">
                                                <option :value="grade.id" v-for="grade in grades" :key="grade.id">{{ grade.description }}</option>
                                            </select>
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
                                    <td>
                                        <i class="fas fa-spinner fa-spin text-danger spinner-md"></i>
                                    </td>
                                </tr>                    
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Header from '../inc/Header.vue';
import { mapState, mapActions } from 'vuex';
import Swal from 'sweetalert2';
import Axios from 'axios';

export default {
    name: 'ClassMarksheet',
    data(){
        return {
            recordLoad: false,
            form: {
                class_id: null,
                section_id: null
            }
        }
    },
    components:{
        Header
    },
    computed: {
        ...mapState(['grades', 'sessions', 'terms', 'subjects', 'classes', 'sections', 'students'])        
    },
    mounted(){
        this.getGrades(),
        this.getTerms(),
        this.getSessions(),
        this.fetchSubjects(),
        this.fetchSections(),
        this.getClasses()
    },
    methods: {
        ...mapActions(['getGrades', 'getSessions', 'getTerms', 'fetchSubjects', 'getClasses', 'fetchSections', 'searchStudent']),

        processResults(e){
            this.recordLoad = true
            let fd = new FormData(e.target)
            Object.entries(this.$data.form).forEach(val => {
                fd.append(val[0], val[1]);
            });
            Axios.post('/record-class-results', fd)
            .then(res => {
                this.recordLoad = false
                let data = JSON.parse(res.data)
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
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: "Successfully Recorded",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }             
            })
            .catch(err => console.error(err))
            .finally(() => this.recordLoad = false )
        }
    }
}
</script>

<style scoped>
i.spinner-md{
    font-size: 30px;
}
</style>