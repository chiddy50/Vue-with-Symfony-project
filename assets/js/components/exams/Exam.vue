<template>
    <div class="row">
        <Header :title="'Exams'" :title2="'Add Exam Schedule'"/>

        <div class="col-4-xxxl col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Add New Exam</h3>
                        </div>
                    </div>
                    <form @submit.prevent="addExam($event)" class="new-added-form">
                        <div class="row">
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Exam Name</label>
                                <input type="text" name="exam_name" class="form-control">
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Subject Type *</label>
                                <select name="subject" class="form-control select2 rounded-0">
                                    <option value="">Please Select Subject</option>
                                    <option v-for="subject in subjects" :key="subject.id" :value="subject.id">{{ subject.subject }}</option>
                                </select>
                            </div>
                            <div class="col-12-xxxl col-lg-4 col-12 form-group">
                                <label>Class *</label>
                                <select name="class" class="form-control select2 rounded-0">
                                    <option value="">Please Select Class</option>
                                    <option v-for="cl in classes" :key="cl.id" :value="cl.id">{{ cl.class_name }}</option>
                                </select>
                            </div>
                            <div class="col-12-xxxl col-lg-4 col-12 form-group">
                                <label>Section</label>
                                <select name="section" class="form-control select2 rounded-0">
                                    <option value="">Please Select Section</option>
                                    <option v-for="section in sections" :key="section.id" :value="section.id">{{ section.section_name }}</option>
                                </select>
                            </div>
                            <div class="col-12-xxxl col-lg-4 col-12 form-group">
                                <label>Group</label>
                                <select name="group" class="form-control select2 rounded-0">
                                    <option value="">Please Select Group</option>
                                    <option v-for="group in student_group" :key="group.id" :value="group.id">{{ group.group_name }}</option>
                                </select>
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Session</label>
                                <select name="session" class="form-control select2 rounded-0">
                                    <option value="">Please Select Session</option>
                                    <option v-for="session in sessions" :key="session.id" :value="session.id">{{ session.session }}</option>
                                </select>
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Term</label>
                                <select name="term" class="form-control select2 rounded-0">
                                    <option value="">Please Select Term</option>
                                    <option v-for="term in terms" :key="term.id" :value="term.id">{{ term.termCode }}</option>
                                </select>
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Select Time</label>
                                <input type="text" name="time" class="form-control" placeholder="e.g 10.00 am - 11.00 am">
                                <i class="far fa-clock"></i>
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
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
        <div class="col-8-xxxl col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>All Exam Schedule</h3>
                        </div>
                    </div>
                    <form class="mg-b-20">
                        <div class="row gutters-8">
                            <div class="col-lg-4 col-12 form-group">
                                <input type="text" placeholder="Search by Exam ..." class="form-control">
                            </div>
                            <div class="col-lg-3 col-12 form-group">
                                <input type="text" placeholder="Search by Subject ..." class="form-control">
                            </div>
                            <div class="col-lg-3 col-12 form-group">
                                <input type="text" placeholder="Search by Date ..." class="form-control">
                            </div>
                            <div class="col-lg-2 col-12 form-group">
                                <button type="submit"
                                    class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table display data-table table-striped table-bordereds text-nowrap">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkAll">
                                            <label class="form-check-label">Exam Name</label>
                                        </div>
                                    </th>
                                    <th>Subject</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Time</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input">
                                            <label class="form-check-label">Class Test</label>
                                        </div>
                                    </td>
                                    <td>Mathematics</td>
                                    <td>4</td>
                                    <td>A</td>
                                    <td>10.00 am - 11.00 am</td>
                                    <td>20/06/2019</td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false">
                                                <span class="flaticon-more-button-of-three-dots"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#"><i
                                                        class="fas fa-times text-orange-red"></i>Close</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <button @click="getExams">Test</button>
    </div>
</template>

<script>
import Header from '../inc/Header.vue';
import { mapActions, mapState } from 'vuex';
import Axios from 'axios';


export default {
    data(){
        return{
            exam: ''
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
            .then(res => {
                console.log(res);      
                // this.exam = res.data.exam          
                // this.exams.push(res.data.exam)
            })
            .catch(err => {
                console.error(err);
            })
        }
    }
}
</script>

<style>

</style>