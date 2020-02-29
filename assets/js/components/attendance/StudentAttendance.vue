<template>
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
            <!-- <Header :title="'Student Attendence'" :title2="'Attendence'"/> -->
            <div class="breadcrumbs-area">
                <h3>Attendance</h3>
                <ul>
                    <li>
                        <router-link to="/" as="a">Home</router-link>
                    </li>
                    <li>Class Attendance</li>
                </ul>
            </div>
        <!-- Breadcubs Area End Here -->
        
        <div class="row">
            <!-- Student Attendence Search Area Start Here -->
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Choose Class & Section</h3>
                            </div>                            
                        </div>
           
                        <form class="new-added-form" @submit.prevent="searchStudent" v-if="attandanceChecker">
                            <div class="row">
                                <div class="col-sm-12 col-xl-12 col-lg-12 col-12 form-group" id="class_box">
                                    <label>Select Class</label>
                                    <select v-if="!classLoading" class="bounceIn form-control" v-model="form.class_id">
                                        <option value="">Select Class</option>
                                        <option :key="one_class.id" v-for="one_class in classes" :value="one_class.id">
                                            {{ one_class.class_name }}
                                        </option>                                        
                                    </select>
                                </div>
                                <div class="col-sm-12 col-xl-12 col-lg-12 col-12 form-group" id="section_box">
                                    <label>Select Section</label>
                                    <select v-if="!classLoading" class="bounceIn form-control" v-model="form.section_id">
                                        <option value="">Select Section</option>
                                        <option :key="section.id" v-for="section in sections" :value="section.id">
                                            {{ section.section_name }}
                                        </option>
                                    </select>
                                </div>
                               
                                <div class="col-12 form-group mg-t-8">
                                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Retrieve</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-6" id="session_month">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Choose Month & Session</h3>
                            </div>                            
                        </div>
                        <form class="new-added-form">
                            <div class="row">
                                <div class="col-sm-12 col-xl-12 col-lg-12 col-12 form-group">
                                    <label>Select Month</label>
                                    <select class="bounceIn form-control" v-model="form.month" id="month_box">
                                        <option disables selected>Select Month</option>
                                        <option v-for="month in months" v-bind="month" :key="month.id" :value="month.id">
                                            {{ month.month }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-xl-12 col-lg-12 col-12 form-group" id="session_div">
                                    <label>Select Session</label>
                                    <select class="bounceIn form-control" v-model="form.session" id="session_box">
                                        <option disables selected>Select Session</option>
                                        <option v-for="session in sessions" v-bind="session" :key="session.id" :value="session.id">
                                            {{ session.session }}
                                        </option>                                        
                                    </select>
                                </div>
                                <div class="col-sm-12 col-xl-12 col-lg-12 col-12 form-group" id="date_div">
                                    <label>Select Date</label>
                                    <!-- <datepicker :bootstrap-styling="true" id="my_date" v-model="form.my_date" name="dob"></datepicker> -->
                                    <input type="date" v-model="form.my_date" class="form-control" id="my_date">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12" id="attendance_table">
                <div class="card">
                    <div class="card-body">
                        <form @submit="record($event)">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Attendence For {{ class_name|upper }}: {{ section_name|upper }}</h3>
                                </div>                                                  
                            </div>                        
                            <div class="table-responsive">
                                <table class="table bs-table table-striped table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="text-left">#Roll No</th>
                                            <th>Fullname</th>
                                            <th>If Present?</th>
                                            <th>Record</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="student in students" :key="student.id">
                                            <td class="text-left">{{ student.roll_no }}</td>
                                            <td>{{ student.firstname }} {{ student.lastname }}</td>
                                            <td class="class_status">                    
                                                <label>Present</label>
                                                <input type="radio" class="present_field" :name="'attendance['+[student.id]+']'" value="Present">
                                                <label>Absent</label>
                                                <input type="radio" class="present_field" :name="'attendance['+[student.id]+']'" value="Absent">
                                            </td>
                                            <td class="button_class">
                                                <button v-if="!recordLoading" type="button" @click.prevent="sendAttendance($event,student.id)" class="btn single_attendance btn-lg text-light rounded-circle bg-orange-peel">
                                                    <i class="fas fa-check text-light"></i>
                                                </button>
                                                
                                                <i v-else class="fas fa-spinner fa-spin text-dark"  id="spinner-md"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>                            
                            </div>
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Record</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      
    </div>
</template>

<script>
import Axios from 'axios';
import { mapGetters, mapActions, mapState } from 'vuex';
// import moment from 'moment';
import Datepicker from 'vuejs-datepicker';
import Header from '../inc/Header.vue';


export default {
    name: 'StudentAttendance',
    components:{
        Datepicker,
        Header
    },
    data(){
        return{                
            // class_id: '',
            // section_id: ''
            // ,
            form:{
                class_id: '',
                section_id: '',
                month: '',
                session: '',
                my_date: '',
                student_id: '',
            },
            recordLoading: false,    
            tableLoading: false,
            students: [],
            class_name: '',
            section_name: '',
            returned_id: null
        }
    },
    mounted(){
        this.getClasses(),
        this.fetchSections(),
        this.getSessions(),
        this.getMonths()
    },
    computed:{
         ...mapState(['classes', 
                        'sections', 
                        'months',
                        'sessions',
                        'classLoading',                        
                        ]),
        ...mapGetters(['attandanceChecker'])
    },
    methods:{
        ...mapActions(['getClasses', 'fetchSections', 'getSessions', 'getMonths']),
        searchStudent(e){
            console.log(e);            
            // let class_id = e.target.children[0].children[0].children[1].value;
            // let section_id = e.target.children[0].children[1].children[1].value;

            let formData = new FormData();
            formData.append('class_id', this.form.class_id);
            formData.append('section_id', this.form.section_id);
            // let _fd = this.$data.form;
            // Object.entries(_fd).forEach(function(val) {
            //     formData.append(val[0], val[1]);
            // });

            Axios.post('/students-by-class', formData)
            .then(response => {
                let data = response.data;
                if(data.error == true){
                    this.$swal(data.message)
                }else if(!data.students.length) {
                    this.$swal('There are no Students')
                    
                }else {
                    $('#session_month').slideDown(500);
               
                    this.$swal(data.message);
                    this.students = data.students[0];  
                    this.class_name = data.class_name;
                    this.section_name = data.section_name;   
                    $('#attendance_table').fadeIn(500);     
                 
                }
                console.log(data);
                console.log(data.students[0]);                
            })
            .catch(err => {
                console.error(err);                
            })
        },
        sendAttendance(e, id){
            var status;
            
            // if (e.target.classList.contains('single_attendance')) {
            //     var status = e.target.parentElement.previousElementSibling.children[0].value;                     
            // }else if (e.target.classList.contains('fa-check')) {
            //     var status = e.target.parentElement.parentElement.previousElementSibling.children[0].value;                     
            // }
            
            //Check if button was clicked
            if (e.target.classList.contains('single_attendance')) {
                if (e.target.parentElement.previousElementSibling.children[1].checked) {
                status = e.target.parentElement.previousElementSibling.children[1].value;
                }else if(e.target.parentElement.previousElementSibling.children[3].checked){
                    status = e.target.parentElement.previousElementSibling.children[3].value;
                }             
            //Check if icon tag inside button was clicked
            }else if (e.target.classList.contains('fa-check')) {
                if (e.target.parentElement.parentElement.previousElementSibling.children[1].checked) {
                status = e.target.parentElement.parentElement.previousElementSibling.children[1].value;
                }else if(e.target.parentElement.parentElement.previousElementSibling.children[3].checked){
                    status = e.target.parentElement.parentElement.previousElementSibling.children[3].value;
                }                     
            }
                        
            console.log(status);
            
           
            this.form.student_id = id;
            let _fd = this.$data.form;

            if (this.form.my_date == '' || this.form.student_id == '' || this.form.session == '' || this.form.month == '') {
                this.$swal("Fill all fields")
            }else{
                this.recordLoading = true
                let formData = new FormData();
                Object.entries(_fd).forEach(val => {
                    formData.append(val[0], val[1]);
                });
                formData.append('status', status)
                
                Axios.post('/attendance/one', formData)
                .then(res => {
                    this.recordLoading = false
                    console.log(res);
                    let data = res.data;
               
                    if (data.error == true) {
                        Swal.fire(data.message)
                    }else{
                        Swal.fire(data.message);                        
                    }
                    
                })
                .catch(err => {
                    this.recordLoading = false
                    console.error(err);
                    
                })
            }
        },
        record(e){
            e.preventDefault()
            let formData = new FormData(e.target);
            let _fd = this.$data.form;
            Object.entries(_fd).forEach(val => {
                formData.append(val[0], val[1]);
            });
            Axios.post('/attendance/all', formData)
            .then(res => {
                console.log(res);                                  
            })
            .catch(err => {
                console.error(err);                    
            })
        }
        
    },
    filters:{
        upper(val){
            return val.toUpperCase();
        }
    }
}
</script>


<style scoped>
    #attendance_table{
        display: none;
    }

    #session_month{
        display: none;
    }

    #att_success{
        display: none;
    }

    #att_error{
        display: none;
    }
</style>