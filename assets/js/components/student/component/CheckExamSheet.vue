<template>
    <div class="col-lg-12">
        <div class="card dashboard-card-eleven">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Check Exam Records</h3>
                    </div>
                    
                </div>
                <div class="table-box-wrap">
                    <form class="search-form-box" @submit.prevent="getExamRecords($event)">
                        <div class="row gutters-8">
                            <div class="col-lg-4 col-12 form-group">
                                <select class="form-control" name="term">
                                    <option disabled selected>Select Term</option>
                                    <option v-for="term in terms" :key="term.id" :value="term.id">
                                        {{ term.term_code }}
                                    </option>                                        
                                </select>
                            </div>
                            <div class="col-lg-3 col-12 form-group">
                                <select class="form-control" v-model="form.session" name="session">
                                    <option disabled selected>Select Session</option>
                                    <option v-for="session in sessions" v-bind="session" :key="session.id" :value="session.id">
                                        {{ session.session }}
                                    </option>                                        
                                </select>
                            </div>
                            <div class="col-lg-2 col-12 form-group">
                                <button type="submit" class="fw-btn-fill btn-gradient-yellow" :disabled="loading">SEARCH</button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="table-responsive result-table-box" v-if="records.length">
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
                                <tr v-for="(record, index) in records" :key="index" class="text-center">
                                    <td>{{ record.subject.subject }}</td>
                                    <td>{{ record.grade.grade }}</td>                                    
                                    <td>{{ record.score }}</td>                                    
                                    <td :class="commentClass(record.grade.grade)">{{ record.grade.comment }}</td>                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box mt-5" v-if="loading">
                        <i class="fas fa-spinner fa-spin text-dark spinner-md"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Axios from 'axios';
import { mapActions, mapState } from 'vuex';

export default {
    name: 'CheckExamSheet',
    props: ['student_id'],
    data(){
        return{              
            loading: false,  
            form:{
                month: '',
                session: '',
            },
            records: []
        }
    },
    created(){
        this.getSessions(),
        this.getTerms()        
    },
    computed:{
        ...mapState(['sessions', 'terms']),
    },
    methods:{
        ...mapActions(['getSessions', 'getTerms']),
        getExamRecords(e){
            this.loading = true
            let self = this
            let _fd = new FormData(e.target)
            _fd.append('student_id', this.student_id)
            Axios.post('/check-exam-records', _fd)
            .then(res => {
                self.loading = false
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
                }         
            })
            .catch(err => console.error(err))
            .finally(() =>  this.loading = false)
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
    justify-content: center;
    align-items: center;
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