<template>
    <div class="row">
        <Header :title="'Student'" :title2="'Marksheet'"/>

        <div class="col-lg-12">
            <div class="card dashboard-card-eleven">
                <div class="card-body">

                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>{{ student.firstname }} {{ student.lastname }}</h3>
                        </div>
                        
                    </div>

                    <div class="table-box-wrap">
                        <form class="search-form-box">
                            <div class="row gutters-8">
                                <div class="col-lg-4 col-md-8 col-sm-12 col-12" v-if="studentSubject.length">
                                   <button type="button" class="modal-trigger" data-toggle="modal" data-target="#large-modal">
                                        Mark Sheet
                                    </button>
                                </div>        
                                                    
                            </div>

                            <div class="row gutters-8">
                                <div class="col-lg-4 col-md-8 col-sm-12 col-12">
                                    <h4>{{ current_term }}</h4>
                                </div>
                                <div class="col-lg-4 col-md-8 col-sm-12 col-12">
                                    <h4>{{ current_session }}</h4>
                                </div>
                            </div>
                        
                            <!-- <div class="table-responsive result-table-box hide-table" v-if="hideTable">
                                <table class="table display data-table table-striped table-bordered text-nowrap">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Subject</th>
                                            <th>Grade</th>
                                            <th>Score</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>                            
                                        <tr class="text-center" v-for="(result, index) in results" :key="index">
                                            <td>{{ result.subject }}</td>                                     
                                            <td>{{ result.grade }}</td>                                     
                                            <td>{{ result.score }}</td>                                     
                                            <td :class="commentClass(result.grade)">{{ result.comment }}</td>                                     
                                        </tr>
                                    </tbody>
                                </table>                            
                            </div>  -->

                            <MarksheetTable v-if="hideTable" :results="results"/>                                               
                        </form>
                    </div>

                    <div class="box load-box">
                        <h3 class="error text-center"></h3>
                    </div>
                    <div class="box loader" v-if="loader">
                        <h3 class="text-muted">Please wait....</h3>
                    </div>   
                    
                </div>
            </div>
        </div>

        <div class="modal fade" id="large-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ student.firstname }} {{ student.lastname }}'s Mark Sheet</h5>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="search-form-box" @submit.prevent="sendScores">
                        <div class="modal-body">
                            <div class="row gutters-8">
                                <div class="col-lg-4 col-12 form-group" >
                                    <select class="form-control" name="session">
                                        <option disabled selected>Select Session</option>
                                        <option v-for="session in sessions" :key="session.id" :value="session.id">
                                            {{ session.session }}
                                        </option>                                        
                                    </select>
                                </div>
                                <div class="col-lg-4 col-12 form-group" >
                                    <select class="form-control" name="term">
                                        <option disabled selected>Select Term</option>
                                        <option v-for="term in terms" :key="term.id" :value="term.id">
                                            {{ term.term_code }}
                                        </option>                                        
                                    </select>
                                </div>
                                <div class="col-lg-4 col-12 form-group" >
                                    <input type="date" name="date" class="form-control">                                
                                </div>
                            </div>
                            <div class="row gutters-8" v-for="subject in formattedSubjects" :key="subject.id">
                                <div class="col-lg-4 col-12 form-group text-center" >
                                    {{ subject.subject }}
                                    <input type="hidden" :value="subject.id" :name="'subject['+[subject.id]+']'" class="form-control">
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <select class="form-control" :name="'grade['+[subject.id]+']'">
                                        <option :value="grade.id" v-for="grade in subject.grades" :key="grade.id">{{ grade.description }}</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-12 form-group">
                                    <input type="number" placeholder="Score.." :name="'student_score['+[subject.id]+']'" class="form-control">
                                </div>
                                <hr>
                            </div>                        
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="footer-btn bg-dark-low"
                                data-dismiss="modal">Close</button>
                            <button :disabled="sendScoresLoad" type="submit" class="footer-btn bg-linkedin">Save
                                Changes</button>
                        </div>
                    </form>
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
    props: {
        student: Object
    },
    data(){
        return{
            hideTable: true,
            loader: false,
            sendScoresLoad: false,
            studentSubject: [],
            results: [],
            firstname: '',
            lastname: '',
            current_term: '',
            current_session: '' 

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
        this.getStudentSubject()
    },
    methods:{
        ...mapActions(['getGrades', 'getSessions', 'getTerms']),
        getStudentSubject(){
            
            this.loader = true;
            this.studentSubject = [];
        
            let formData = new FormData();
            formData.append('group_id', this.student.student_group.id);

            Axios.post('/studentsubject', formData)
            .then(res => {
                this.loader = false
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
                    this.studentSubject = data.subjects;                    
                }
                
            })
            .catch(err => {
                console.log(err);            
            })
            .finally(() => this.loader = false);
        },
        sendScores(e){
            this.sendScoresLoad = true
            let fd = new FormData(e.target)
            fd.append('student_id', this.student.id)
            Axios.post('/record-exam-scores', fd)
            .then(res => {
                // this.sendScoresLoad = false
                // this.hideTable = false;
                // if (!res.data.error) {
                //     this.results = res.data.results
                //     this.current_session = res.data.session
                //     this.current_term = res.data.term
                // }
                console.log(res);                
            })
            .catch(err=> console.error(err))
            .finally(() => this.sendScoresLoad = false )
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
    font-size: 50px;
}
.box{
    display: flex;
    align-items: center;
    justify-content: center;
}
.load-box{
    display: none;
}

.hide-table{
    display: none;
}

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