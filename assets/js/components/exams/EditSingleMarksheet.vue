<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="breadcrumbs-area">
                <h3>Student</h3>
                <ul>
                    <li>
                        <router-link to="/" as="a">Home</router-link>
                    </li>
                    <li>Edit Marksheet</li>
                </ul>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card dashboard-card-eleven">
                <div class="card-body">

                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3 class="text-uppercase">{{ firstname }} {{ lastname }}</h3>
                        </div>                        
                    </div>

                    <div class="table-box-wrap">
                        <form @submit.prevent="checkExamRecord($event)" class="search-form-box">
                            <div class="row gutters-8">
                                <div class="col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                                   <select class="form-control" v-model="form.session" name="session">
                                        <option disabled selected>Select Session</option>
                                        <option v-for="session in sessions" :key="session.id" :value="session.id">
                                            {{ session.session }}
                                        </option>                                        
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                                    <select class="form-control" v-model="form.term" name="term">
                                        <option disabled selected>Select Term</option>
                                        <option v-for="term in terms" :key="term.id" :value="term.id">
                                            {{ term.term_code }}
                                        </option>                                        
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                                    <datepicker :format="formatter" :bootstrap-styling="true" :value="form.date" v-model="form.date" name="date"></datepicker>                                
                                </div>
                                <div class="col-1-xxxl col-xl-2 col-lg-3 col-md-3 col-12 form-group">
                                    <button type="submit" class="fw-btn-fill btn-gradient-yellow" :disabled="checkLoad">SEARCH</button>
                                </div>
                            </div>
                        </form>
                        
                        <div class="table-responsive result-table-box" v-if="!checkLoad">
                            <form @submit.prevent="updateRecords($event)">                        
                                <table class="table display data-table table-striped table-bordered text-nowrap">
                                    <thead>
                                        <tr class="text-center">
                                            <th>SUBJECT</th>
                                            <th>1ST C/A</th>
                                            <th>2ND C/A</th>
                                            <th>EXAM</th>
                                            <th>TOTAL</th>
                                            <th>GRADE</th>
                                            <th>REMARK</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>      
                                        <tr v-for="record in records" :key="record.id">   
                                            <td>                                           
                                                <input type="hidden" :value="record.subject.id" :name="'subject['+[record.subject.id]+']'">
                                                <input type="hidden" :value="record.class.id" name="class_id">
                                                <input type="hidden" :value="record.section.id" name="section_id">
                                                <input type="text" :placeholder="record.subject.subject" disabled class="form-control">
                                            </td>  
                                            <td>
                                                <input type="number" placeholder="1st C/A" :name="'first_ca['+[record.subject.id]+']'" v-model="record.first_ca" class="form-control">
                                            </td> 
                                            <td>
                                                <input type="number" placeholder="2nd C/A" :name="'second_ca['+[record.subject.id]+']'" v-model="record.second_ca" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" placeholder="Exam" :name="'exam['+[record.subject.id]+']'" v-model="record.exam" class="form-control">
                                            </td> 
                                            <td>
                                                <input type="number" placeholder="total" :name="'total['+[record.subject.id]+']'" v-model="record.total" class="form-control">
                                            </td>
                                            <td>
                                                <select v-model="record.grade.id" class="form-control" :name="'grade['+[record.subject.id]+']'">
                                                    <option disabled>Choose Grade</option>
                                                    <option :value="grade.id" v-for="grade in grades" :key="grade.id">{{ grade.description }} - {{ grade.grade }}</option>
                                                </select>
                                            </td> 
                                            <td>
                                                <input type="text" :placeholder="record.grade.comment" disabled class="form-control">
                                            </td>                                                                                   
                                            <td class="text-center">
                                                <button @click.prevent="deleteExamResult(record.id)" class="btn btn-lg shadow-dark-peel bg-danger rounded-bottom text-light text-center">
                                                <i class="fas fa-trash text-light"></i>
                                                </button>
                                            </td>                              
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="submit" :disabled="!records.length" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark rounded-0">
                                    Update
                                </button>
                                <button class="btn-fill-lg bg-blue-dark btn-hover-yellow rounded-0">Back</button>
                            </form>
                        
                        </div>

                        <div class="flex" v-else>
                            <i class="fas fa-spinner fa-spin text-danger spinner-md"></i>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2'
import Axios from 'axios';
import Header from '../inc/Header.vue';
import { mapState, mapActions } from 'vuex';
import Datepicker from 'vuejs-datepicker';


export default {
    name: 'EditSingleMarksheet',
    data(){
        return{
            records: [],
            firstname: null,
            lastname: null,
            checkLoad: false,
            uploadLoad: false,
            form: {
                session: null,
                term: null,
                date: null,
                section_id: null,
                class_id: null,
                student_id: this.$route.params.id                
            }
        }
    },
    components:{
        Datepicker
    },
    computed: {
        ...mapState(['grades', 'sessions', 'terms', 'subjects']),
        id() {
            return this.$route.params.id
        }
    },
    mounted(){
        this.getGrades(),
        this.getTerms(),
        this.getSessions(),
        this.fetchSubjects()
    },
    methods: {
        ...mapActions(['getTerms', 'getSessions', 'fetchSubjects', 'getGrades']),
        
        checkExamRecord(e){
            this.checkLoad = true;
            let self = this;
            let fd = new FormData(e.target)
            fd.append('student_id', this.$route.params.id)
            Axios.post('/check-exam-records', fd)
            .then(res => {
                this.checkLoad = false
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
                    self.records = data.records
                    self.firstname = data.firstname
                    self.lastname = data.lastname
                    self.form.date = data.records[0].date
                    self.form.class_id = data.records[0].class.id
                    self.form.section_id = data.records[0].section.id
                }
            })
            .catch(err => console.error(err))
            .finally(() => { this.checkLoad = false })
        },

        updateRecords(e){
            this.uploadLoad = true
            let self = this;
            let fd = new FormData(e.target);
            // fd.append('student_id', this.$route.params.id)
            // fd.append('session', this.form.session)
            // fd.append('term', this.form.term)
            // fd.append('date', this.form.date)
            // fd.append('class_id', this.form.class_id)
            // fd.append('section_id', this.form.section_id)
            Object.entries(this.$data.form).forEach(val => {
                fd.append(val[0], val[1]);
            })
            Axios.post('/update-exam-results', fd)
            .then(res => {
                self.uploadLoad = false
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
                console.log(data);

            })
            .catch(err => console.error(err))
            .finally(() => { self.uploadLoad = false })
        },

        formatter(date) {
            return moment(date).format('MMMM-Do-YYYY');
        },
    }

}
</script>

<style scoped>
    .flex{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .spinner-md{
        font-size: 60px;
    }
</style>