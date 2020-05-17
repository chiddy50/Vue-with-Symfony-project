<template>
    <div class="row">
        <Header :title="'Student'" :title2="'Marksheet'"/>

        <div class="col-sm-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>RESULT PROCESSING SHEET</h3>
                        </div>                        
                    </div>
                    <form @submit.prevent="sendExamResult($event)" class="mg-b-20">
                        <div class="row gutters-8">
                            <div class="col-3-xxxl col-xl-4 col-lg-3 col-12 form-group">
                                <select class="form-control" name="session">
                                    <option disabled selected>Select Session</option>
                                    <option v-for="session in sessions" :key="session.id" :value="session.id">
                                        {{ session.session }}
                                    </option>                                        
                                </select>
                            </div>
                            <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <select class="form-control" name="term">
                                    <option disabled selected>Select Term</option>
                                    <option v-for="term in terms" :key="term.id" :value="term.id">
                                        {{ term.term_code }}
                                    </option>                                        
                                </select>
                            </div>
                            <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <input type="date" name="date" class="form-control">                                
                            </div>
                            <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                <button type="submit" :disabled="sendResultLoad" class="fw-btn-fill btn-gradient-yellow">RECORD</button>
                            </div>
                        </div>
                    
                        <div class="table-responsive">
                            <table class="table display data-table table-striped table-bordered text-nowrap">
                                <thead>
                                    <tr>                                    
                                        <th>
                                            <i v-if="sendResultLoad" class="fas fa-spinner fa-spin text-danger spinner-md"></i>
                                        </th>
                                        <th colspan="5">Name: {{ firstname }} {{ lastname }}</th>                                    
                                    </tr>
                                    <tr>                                    
                                        <th>SUBJECT</th>
                                        <th>1ST C/A</th>
                                        <th>2ND C/A</th>
                                        <th>EXAM</th>
                                        <th>TOTAL</th>
                                        <th>GRADE</th>                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="subject in formattedSubjects" :key="subject.id">
                                        <td>
                                            <input type="hidden" :value="subject.id" :name="'subject['+[subject.id]+']'" class="form-control">                                        
                                            {{ subject.subject }}
                                        </td>
                                        <td><input type="number" class="form-control" :name="'first_ca['+[subject.id]+']'" placeholder="1st C/A"></td>
                                        <td><input type="number" class="form-control" :name="'second_ca['+[subject.id]+']'" placeholder="2nd C/A"></td>
                                        <td><input type="number" class="form-control" :name="'exam['+[subject.id]+']'" placeholder="Exam"></td>
                                        <td><input type="number" class="form-control" :name="'total['+[subject.id]+']'" placeholder="Total"></td>
                                        <td>
                                            <select class="form-control" :name="'grade['+[subject.id]+']'">
                                                <option :value="grade.id" v-for="grade in subject.grades" :key="grade.id">{{ grade.description }}</option>
                                            </select>
                                        </td>
                                    </tr>                          
                                </tbody>
                                                    
                            </table>
                        </div>
                    </form>

                    <div class="box load-box">
                        <h3 class="error text-center"></h3>
                    </div>
                    <div class="box loader" v-if="loader">
                        <h3 class="text-muted text-info">Please wait....</h3>
                    </div>  
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card dashboard-card-eleven">
                <div class="card-body">

                    <div class="heading-layout1">
                        <div class="item-title">
                            <!-- <h3>{{ student.firstname }} {{ student.lastname }}</h3> -->
                        </div>
                        
                    </div>

                    <div class="table-box-wrap">
                        <form class="search-form-box">
                            <div class="row gutters-8">
                                <div class="col-lg-4 col-md-8 col-sm-12 col-12">
                                    <h4>{{ current_term }}</h4>
                                </div>
                                <div class="col-lg-4 col-md-8 col-sm-12 col-12">
                                    <h4>{{ current_session }}</h4>
                                </div>
                            </div>
                        
                            <!-- <div class="table-responsive result-table-boxs">
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
                                        </tr>
                                    </thead>
                                    <tbody>                            
                                        <tr class="text-center" v-for="(result, index) in results" :key="index">
                                            <td>{{ result.subject }}</td>                                     
                                            <td>{{ result.first_ca }}</td>                                     
                                            <td>{{ result.second_ca }}</td>                                     
                                            <td>{{ result.exam }}</td>                                     
                                            <td>{{ result.total }}</td>                                     
                                            <td>{{ result.grade }}</td>                                     
                                            <td :class="commentClass(result.grade)">{{ result.comment }}</td>                                     
                                        </tr>
                                    </tbody>
                                </table>                            
                            </div>  -->

                            <MarksheetTable v-if="results.length" :results="results"/>                                               
                        </form>
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
import MarksheetTable from './MarksheetTable.vue'
import { mapState, mapActions } from 'vuex';

export default {
    name: 'Marksheet',
    components: {
        Header,
        MarksheetTable
    },
    
    data(){
        return{
            studentSubject: [],
            results: [],
            hideTable: true,
            loader: false,
            sendResultLoad: false,
            firstname: null,
            lastname: null,
            class_id: null,
            section_id: null,
            current_term: null,
            current_session: null 
        }
    },
    computed:{
        ...mapState(['grades', 'sessions', 'terms']),
        formattedSubjects(){
            var grades = this.grades;
            var val = []
            this.studentSubject.forEach(sub => {
                val.push({
                    subject: sub.subject,
                    id: sub.id,
                    grades: grades
                })                
            })
            return val
        }
    },
    created(){
        this.getGrades(),
        this.getSessions(),
        this.getTerms()        
    },
    beforeMount(){
        this.getStudentSubject(this.$route.params.id)
    },
    methods:{
        ...mapActions(['getGrades', 'getSessions', 'getTerms']),
        getStudentSubject(id){
            
            this.loader = true;
            this.studentSubject = [];
        
            let formData = new FormData();
            formData.append('id', id);
            Axios.post('/get-student-subjects', formData)
            .then(res => {
                this.loader = false
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
                    this.studentSubject = data.subjects;                    
                    this.firstname = data.firstname;                    
                    this.lastname = data.lastname;                    
                    this.class_id = data.class_id;                    
                    this.section_id = data.section_id;                    
                }
                
            })
            .catch(err => {
                console.log(err);            
            })
            .finally(() => this.loader = false);
        },
        sendExamResult(e){
            let self = this;
            this.sendResultLoad = true;
            let fd = new FormData(e.target);
            fd.append('section_id', this.section_id);
            fd.append('class_id', this.class_id);
            fd.append('student_id', this.$route.params.id);
            Axios.post('/record-student-results', fd)
            .then(res => {
                self.sendResultLoad = false
                let data = JSON.parse(res.data)
                console.log(res);
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
                    self.results = data.results
                    self.current_session = data.session
                    self.current_term = data.term
                    self.hideTable = false;
                }             
            })
            .catch(err => console.error(err))
            .finally(() => self.sendResultLoad = false )
        },
        commentClass(grade){	
			let answerClass = '';
			if (grade === 'A') {
				answerClass = 'excellent'
			}else if (grade === 'B') {
				answerClass = 'veryGood'
			}else if (grade === 'C') {
				answerClass = 'satisfactory'
			}else if (grade === 'D') {
				answerClass = 'fair'
			}else if (grade === 'F') {
				answerClass = 'failed'
			}
			return answerClass;
			
		}
    }
}
</script>

<style scoped>
.spinner-md{
    font-size: 40px;
}
.box{
    display: flex;
    align-items: center;
    justify-content: center;
}
.load-box{
    display: none;
}

/* ---- */


.failed{
    color: #ff4444;
}
.veryGood{
    color: #2e42f1;
}
.satisfactory{
    color: #44f9ff;
}
.fair{
    color: pink;
}
.excellent{
    color: #35ec35;
}
</style>