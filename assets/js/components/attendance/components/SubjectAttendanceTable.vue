<template>
    <div class="col-lg-12">
        <div class="card dashboard-card-eleven">
            <div class="card-body">

                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Choose Subject & Date</h3>
                    </div>
                    
                </div>

                <div class="table-box-wrap">
                    <form @submit.prevent="submitSubjectAttendance($event)" class="search-form-box">
                        <div class="row gutters-8">
                            <div class="col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                                <select class="form-control" v-model="form.subject" name="subject">
                                    <option disabled selected>Select Subject</option>
                                    <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                        {{ subject.subject }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                                <select class="form-control" v-model="form.month" name="month">
                                    <option disabled selected>Select Month</option>
                                    <option v-for="month in months" v-bind="month" :key="month.id" :value="month.id">
                                        {{ month.month }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                                <select class="form-control" v-model="form.session" name="session">
                                    <option disabled selected>Select Session</option>
                                    <option v-for="session in sessions" v-bind="session" :key="session.id" :value="session.id">
                                        {{ session.session }}
                                    </option>                                        
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                                <input type="date" name="date" v-model="form.date" class="form-control">
                            </div>
                        </div>
                    
                        <div class="table-responsive result-table-box">
                            <table class="table display data-table table-striped table-bordered text-nowrap">
                                <thead>
                                    <tr class="text-center">
                                        <th>Roll No</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Record</th>
                                    </tr>
                                </thead>
                                <tbody>                            
                                    <tr class="text-center" v-for="student in filteredStudents" :key="student.id">
                                        <td>{{ student.roll_no }}</td>
                                        <td>{{ student.firstname }} {{ student.lastname }}</td>
                                        <td>
                                            <label>Present</label>
                                            <input type="radio" class="present_field" :name="'attendance['+[student.id]+']'" value="Present">
                                            <label>Absent</label>
                                            <input type="radio" class="present_field" :name="'attendance['+[student.id]+']'" value="Absent">
                                        </td>   
                                        <td class="button_class">
                                            <button :disabled="singleRecordLoading" type="button" @click.prevent="takeSingleSubjectAttendance($event, student.id)" class="btn single_attendance btn-lg text-light rounded-circle bg-orange-peel">
                                                <i class="fas fa-check text-light"></i>
                                            </button>
                                            
                                            <i class="fas fa-spinner fa-spin text-dark spinner-md"></i>
                                        </td>                                     
                                    </tr>
                                </tbody>
                            </table>
                                <button :disabled="singleRecordLoading" type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark rounded-0">
                                    Record
                                </button>      
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Axios from 'axios';
import { mapState, mapActions } from 'vuex'

export default {
    name: 'SubjectAttendanceTable',
    props: ['subjects'],
    data(){
        return{
            singleRecordLoading: false,
            form:{
                month: '',
                session: '',
                subject: '',
                date: '',
                student_id: ''
            }
        }
    },
    mounted(){
        this.getSessions(),
        this.getMonths(),
        this.fetchSubjects()
    },
     computed:{
        ...mapState(['months', 'sessions', 'filteredStudents']),
    },
    methods:{
        ...mapActions(['getSessions', 'getMonths', 'fetchSubjects']),
        submitSubjectAttendance(e){
            this.singleRecordLoading = true
            let fd = new FormData(e.target);
            Axios.post('/student-subject-attendance', fd)
            .then(res => {
                this.singleRecordLoading = false

                let data = JSON.parse(res.data)    
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
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }          
            })
            .catch(err => {
                console.error(err);                
            })
            .finally(() => this.singleRecordLoading = false )
        },
        takeSingleSubjectAttendance(e, id){
            var status, target, spinner;
            if (e.target.classList.contains('single_attendance')) {
                target = e.target;
                target.hidden = true;
                spinner = e.target.nextElementSibling;
                spinner.classList.remove('spinner-md');
                if (e.target.parentElement.previousElementSibling.children[1].checked) {
                status = e.target.parentElement.previousElementSibling.children[1].value;
                }else if(e.target.parentElement.previousElementSibling.children[3].checked){
                    status = e.target.parentElement.previousElementSibling.children[3].value;
                }             
            //Check if icon tag inside button was clicked
            }else if (e.target.classList.contains('fa-check')) {
                target = e.target.parentElement;
                target.hidden = true;
                spinner = e.target.parentElement.nextElementSibling;
                spinner.classList.remove('spinner-md');
                if (e.target.parentElement.parentElement.previousElementSibling.children[1].checked) {
                status = e.target.parentElement.parentElement.previousElementSibling.children[1].value;
                }else if(e.target.parentElement.parentElement.previousElementSibling.children[3].checked){
                    status = e.target.parentElement.parentElement.previousElementSibling.children[3].value;
                }                     
            }
                        
            this.form.student_id = id;
            let _fd = this.$data.form;

            if (this.form.date === '' || this.form.student_id === '' || this.form.session === '' || this.form.month === '' || this.form.subject === '') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: "Fill all fields",
                    showConfirmButton: false,
                    timer: 1500
                });
            }else{
                this.singleRecordLoading = true
                let formData = new FormData();
                Object.entries(_fd).forEach(val => {
                    formData.append(val[0], val[1]);
                });
                formData.append('status', status)
                
                Axios.post('/single-subject-attendance', formData)
                .then(res => {
                    this.singleRecordLoading = false
                    target.hidden = false;
                    spinner.classList.add('spinner-md');

                    let data = JSON.parse(res.data);
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
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });                      
                    }
                    
                })
                .catch(err => console.error(err) )
                .finally(() => {
                    this.singleRecordLoading = false
                    target.hidden = false;
                    spinner.classList.add('spinner-md');
                })
            }
            
        }
    }
}
</script>

<style scoped>
i.spinner-md{
    display: none !important;
}

</style>