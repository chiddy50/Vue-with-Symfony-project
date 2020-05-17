<template>
    <div class="dashboard-content-one">

        <div class="breadcrumbs-area">
            <h3>Student</h3>
            <ul>
                <li>
                    <router-link to="/">Home</router-link>
                </li>
                <li>Student Details</li>
            </ul>
        </div>

        <div class="row">            
            <!-- Contains students data -->
            <Profile :singleStudent="student" v-if="student" :doa="admission_date" :dob="dob" :dateLoading="dateLoading"/>

            <div class="col-8-xxxl col-12">               
                <!-- <div class="row">
                    <CheckSingleAttendance :student_id="student_id"/>                    
                    <SubjectTable :studentSubject="studentSubject" :firstname="student.firstname"
                     :lastname="student.lastname"/>                                        
                </div> -->
                <div class="row">
                    <div v-if="showError" class="col-8-xxxl col-12 error-box">
                        <h4 class="text-center">{{ student.firstname }} {{ student.lastname }} has no subjects</h4>
                    </div>
                </div>
                <div class="row">
                    <MonthlyAttendance :student_id="student_id"/>
                </div>

                <div class="row">
                    <ExamRecord :student_id="student_id"/>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';
import Axios from 'axios';
import SubjectTable from './component/SubjectTable.vue';
import Profile from './component/ProfileBox.vue';
import CheckSingleAttendance from './component/CheckSingleAttendance.vue';
import MonthlyAttendance from './component/CheckMonthAttendance.vue';
import ExamRecord from './component/CheckExamSheet.vue';
import moment from 'moment';

export default {
    name:'SingleStudent',
    components:{
        SubjectTable, 
        Profile, 
        CheckSingleAttendance,
        MonthlyAttendance,
        ExamRecord
    },
    props: {
        student: Object
    },
	data(){
		return{
            studentSubjectLoad: false,
            dateLoading: false,
            studentSubject: [],
            student_id: this.student.id,
            showError: false,
            admission_date: null,
            dob: null
        }   
	},

	created(){
        this.getStudentSubject(this.student.student_group.id)
    },
    mounted(){
        this.setDates()
    },
	methods:{
        ...mapActions(['getClasses', 'fetchSections', 'getSessions', 'getMonths']),
        setDates(){
            this.dob = moment(this.student.admission_date).format('MMMM Do YYYY');     
            this.admission_date = moment(this.student.doa).format('MMMM Do YYYY');
        },
        getStudentSubject(payload){
            this.studentSubject = [];
            this.studentSubjectLoad = true;
        
            let formData = new FormData();
            formData.append('group_id', payload);

            Axios.post('/get-group-subjects', formData)
            .then(res => {
                let subjects = res.data.subjects;
                this.studentSubjectLoad = false;

                if (!res.data.error) {
                    this.studentSubject = subjects;
                }else{
                    this.showError = true
                }
                console.log(res);
            })
            .catch(err => {
                this.studentSubjectLoad = false;
                console.log(err);            
            })
            .finally(() => this.studentSubjectLoad = false )
        },
	}
}
</script>

<style scoped>
.error-box{
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>