<template>
    <div class="row">
        <Header :title="'Exams'" :title2="'Add Exam Schedule'"/>

        <div class="col-12-xxxl col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Add New Exam</h3>
                        </div>
                    </div>
                    <form @submit.prevent="addExam($event)" class="new-added-form">
                        <div class="row">
                            <div class="col-3-xxxl col-lg-6 col-12 form-group">
                                <label>Exam Name</label>
                                <input type="text" name="exam_name" class="form-control">
                            </div>
                            <div class="col-3-xxxl col-lg-6 col-12 form-group">
                                <label>Subject Type *</label>
                                <select name="subject" class="form-control select2 rounded-0">
                                    <option value="">Please Select Subject</option>
                                    <option v-for="subject in subjects" :key="subject.id" :value="subject.id">{{ subject.subject }}</option>
                                </select>
                            </div>
                            <div class="col-3-xxxl col-lg-4 col-12 form-group">
                                <label>Class *</label>
                                <select name="class" class="form-control select2 rounded-0">
                                    <option value="">Please Select Class</option>
                                    <option v-for="cl in classes" :key="cl.id" :value="cl.id">{{ cl.class_name }}</option>
                                </select>
                            </div>
                            <div class="col-3-xxxl col-lg-4 col-12 form-group">
                                <label>Section</label>
                                <select name="section" class="form-control select2 rounded-0">
                                    <option value="">Please Select Section</option>
                                    <option v-for="section in sections" :key="section.id" :value="section.id">{{ section.section_name }}</option>
                                </select>
                            </div>
                            <div class="col-3-xxxl col-lg-4 col-12 form-group">
                                <label>Group</label>
                                <select name="group" class="form-control select2 rounded-0">
                                    <option value="">Please Select Group</option>
                                    <option v-for="group in student_group" :key="group.id" :value="group.id">{{ group.group_name }}</option>
                                </select>
                            </div>
                            <div class="col-3-xxxl col-lg-6 col-12 form-group">
                                <label>Session</label>
                                <select name="session" class="form-control select2 rounded-0">
                                    <option value="">Please Select Session</option>
                                    <option v-for="session in sessions" :key="session.id" :value="session.id">{{ session.session }}</option>
                                </select>
                            </div>
                            <div class="col-3-xxxl col-lg-6 col-12 form-group">
                                <label>Term</label>
                                <select name="term" class="form-control select2 rounded-0">
                                    <option value="">Please Select Term</option>
                                    <option v-for="term in terms" :key="term.id" :value="term.id">{{ term.term_code }}</option>
                                </select>
                            </div>
                            <div class="col-3-xxxl col-lg-6 col-12 form-group">
                                <label>Select Time</label>
                                <input type="text" name="time" class="form-control" placeholder="e.g 10.00 am - 11.00 am">
                                <i class="far fa-clock"></i>
                            </div>
                            <div class="col-3-xxxl col-lg-6 col-12 form-group">
                                <label>Select Date</label>
                                <input type="date" name="date" class="form-control">
                            </div>
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                                <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12-xxxl col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Search for Schedule</h3>
                        </div>
                    </div>
                    <form @submit.prevent="examSearch($event)" class="mg-b-20">
                        <div class="row gutters-8">
                            <div class="col-lg-3 col-12 form-group">
                                <input type="text" placeholder="Exam name..." v-model="search" @keyup="liveSearchExam" class="form-control">
                            </div>
                            <div class="col-lg-3 col-12 form-group">
                                <select name="subject" class="form-control select2 rounded-0">
                                    <option value="">Search By Subject</option>
                                    <option v-for="subject in subjects" :key="subject.id" :value="subject.id">{{ subject.subject }}</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-12 form-group">
                                <select name="session" class="form-control select2 rounded-0">
                                    <option value="">Search By Session</option>
                                    <option v-for="session in sessions" :key="session.id" :value="session.id">{{ session.session }}</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-12 form-group">
                                <select name="term" class="form-control select2 rounded-0">
                                    <option value="">Search By Term</option>
                                    <option v-for="term in terms" :key="term.id" :value="term.id">{{ term.term_code }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row gutters-8">
                            <div class="col-lg-4 col-12 form-group">
                                <select name="class" class="form-control select2 rounded-0">
                                    <option value="">Search By Class</option>
                                    <option v-for="cl in classes" :key="cl.id" :value="cl.id">{{ cl.class_name }}</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-12 form-group">
                                <select name="section" class="form-control select2 rounded-0">
                                    <option value="">Search By Section</option>
                                    <option v-for="section in sections" :key="section.id" :value="section.id">{{ section.section_name }}</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-12 form-group">
                                <select name="group" class="form-control select2 rounded-0">
                                    <option value="">Search By Group</option>
                                    <option v-for="group in student_group" :key="group.id" :value="group.id">{{ group.group_name }}</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-12 form-group">
                                <button type="submit" :disbaled="$store.state.examLoading"
                                    class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table display data-table table-striped table-bordereds text-nowrap">
                            <thead>
                                <tr>
                                    <th>Exam Name</th>
                                    <th>Subject</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Time</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody v-if="!$store.state.examLoading">
                                <tr v-for="(exam, index) in exams" :key="index">
                                    <td>{{ exam.exam_name }}</td>
                                    <td>{{ exam.subject.subject }}</td>
                                    <td>{{ exam.classes.class_name }}</td>
                                    <td>{{ exam.section.section_name }}</td>
                                    <td>{{ exam.time }}</td>
                                    <td v-text="setDate(exam.date)"></td>
                                </tr>
                            </tbody>
                            <tr v-else>
                                <td>
                                    <i class="fas fa-spinner fa-spin text-warning spinner-md"></i>
                                </td>
                                <td>
                                    <i class="fas fa-spinner fa-spin text-warning spinner-md"></i>
                                </td>
                                <td>
                                    <i class="fas fa-spinner fa-spin text-warning spinner-md"></i>
                                </td>
                                <td>
                                    <i class="fas fa-spinner fa-spin text-warning spinner-md"></i>
                                </td>
                                <td>
                                    <i class="fas fa-spinner fa-spin text-warning spinner-md"></i>
                                </td>
                                <td>
                                    <i class="fas fa-spinner fa-spin text-warning spinner-md"></i>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <button @click="test">Test</button>
    </div>
</template>

<script>
import Header from '../inc/Header.vue';
import { mapActions, mapState } from 'vuex';
import Axios from 'axios';
import moment from 'moment';


export default {
    data(){
        return{
            exam: '',
            search: null,
            date: null
        }
    },
    components:{
        Header
    },
    mounted(){
        this.fetchSections(),
        this.getTerms(),
        this.getSessions(),
        this.getGroups(),
        this.fetchSubjects(),
        this.getClasses()
    },
    computed:{
        ...mapState(['classes', 'exams', 'sections', 'student_group', 'terms', 'subjects', 'sessions', 'classLoading', 'sectionLoading']),
    },
    methods:{
        ...mapActions(['getClasses', 'fetchSections', 'getTerms', 'getSessions', 'getGroups', 'fetchSubjects', 'getExams']),

        addExam(e){
            let fd = new FormData(e.target)
            Axios.post('/exam/new', fd)
            .then(response => {
                let data = JSON.parse(response.data)
                console.log(data);
                if(data.error){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }else{
                    this.$store.state.exams.push(data.exam)
                }   
            })
            .catch(err => {
                console.error(err);
            })
        },
        liveSearchExam(){
            this.$store.state.examLoading = true

            let formData = new FormData()
            formData.append('name', this.search)
            Axios.post("/live-exam-search", formData)
            .then(response => {
                this.$store.state.examLoading = false
                let data = JSON.parse(response.data)                
                this.$store.state.exams = data.exams;                             
            })
            .catch(err => console.error(err) )
            .finally(() => this.$store.state.examLoading = false )
        },
        examSearch(e){
            this.$store.state.examLoading = true

            let formData = new FormData(e.target)
            Axios.post("/exam-search", formData)
            .then(response => {
                this.$store.state.examLoading = false
                let data = JSON.parse(response.data)
                console.log(data);
                if(data.error){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }else{
                    this.$store.state.exams = data.exams;
                }                                             
            })
            .catch(err => console.error(err) )
            .finally(() => this.$store.state.examLoading = false )
        },
        setDate(date){
            return moment(date).format('MMMM Do YYYY');
        },
        test(){
            let formData = new FormData()
            formData.append('id', 2)

            Axios.post("/studentinfo", formData)
            .then(response => {
                console.log(response);                
                // let data = JSON.parse(response.data)                
            })
            .catch(err => console.error(err) )
        }
    }
}
</script>

<style scoped>
i.spinner-md{
    font-size: 40px;
}
</style>