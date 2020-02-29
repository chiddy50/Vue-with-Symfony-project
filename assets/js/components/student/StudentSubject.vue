<template>
    <div class="dashboard-content-one">
          <div class="breadcrumbs-area">
            <h3>Students</h3>
            <ul>
                <li>
                    <router-link tag="a" to="/">Home</router-link>
                </li>
                <li>Students Subjects </li>
                <li>
                    <a href="" @click="returnToPreviousPage">Back</a>    
                </li>
                <!-- {{ $route.params.student_id }}{{ $route.params.id }} -->
            </ul>
        </div>
   
        <div class="row gutters-20">
            <div class="col-lg-12 col-xl-12 col-12-xxxl">
                <div class="card dashboard-card-six pd-b-20">
                    <div class="card-body">
                        <div class="heading-layout1 mg-b-17">
                            <div class="item-title">
                                <h3>Subjects</h3>
                            </div>
                            <div class="">
                                <a href="#" @click="getStudentSubject($route.params.id)">
                                <i class="fas fa-redo-alt text-orange-peel"></i> 
                                </a>
                            </div>
                        </div>
                        <div class="notice-box-wrap">                            
                            <div class="notice-list" v-for="student in studentSubject" :key="student.id">
                                <div class="post-date bg-skyblue">{{ student.subject }}</div>                               
                            </div>
                            
                            <i class="fas fa-spinner fa-spin text-center text-warning" id="spinner-lg" v-if="studentSubjectLoad"></i>

                            <div class="row gutters-20">
                                <div class="col-lg-12 col-sm-12 col-12" id="show_box">
                                    <div class="card dashboard-card-seven">
                                        <div class="social-media bg-fb hover-fb">
                                            <div class="media media-none--lg">                                            
                                                <div class="media-body space-sm">
                                                    <h1 class="item-title">NO SUBJECTS</h1>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>                                
                            </div>

                        </div>
                    </div>
                </div>
            </div>     
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';
import Axios from 'axios';

export default {
	name:'SingleStudent',
	
	data(){
		return{
            studentSubjectLoad: false,
            studentSubject: [],
		}
	},
	computed:{
        // ...mapState(['studentSubject', 'studentSubjectLoad']),
        ifSubjectEmpty(){
            if(!this.studentSubject.length){
                return true;  
            }else{
                return false;
            }
        }
	},
	created(){
		this.getStudentSubject(this.$route.params.id);
	},
	methods:{
        // ...mapActions(['getStudentSubject']),

        getStudentSubject(payload){
            this.studentSubject = [];
            this.studentSubjectLoad = true;
        
            let formData = new FormData();
            formData.append('group_id', payload);

            Axios.post('/studentsubject', formData)
            .then(res => {
                let subjects = res.data.subjects;
                this.studentSubjectLoad = false;
                if (!subjects.length) {
                    $('#show_box').slideDown(500);
                }
                if (res.data.error === false) {
                    this.studentSubject = subjects;
                }
                console.log(res.data.subjects);
            })
            .catch(err => {
                this.studentSubjectLoad = false;
                console.log(err);            
            });
        },
        
        returnToPreviousPage(){
            window.history.length > 1
            ? this.$router.go(-1)
            : this.$router.push('/')
        },
	}
}
</script>

<style scoped>
#show_box{
    display: none;
}
</style>