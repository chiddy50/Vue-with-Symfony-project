<template>
    <div class="row">
    
        <Header :title="'Students'" :title2="'Student Admit Form'"/>

        <div class="col-sm-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Add New Students</h3>
                        </div>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">...</a>

                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(46px, 51px, 0px);">
                                <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                            </div>
                        </div>
                    </div>
                    
            
                    <form class="new-added-form" data-select2-id="18" @submit.prevent="addStudent">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>First Name *</label>
                                <input type="text" v-model="form.firstname" placeholder="" class="form-control rounded-0">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Last Name *</label>
                                <input type="text" v-model="form.lastname" placeholder="" class="form-control rounded-0">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Gender *</label>
                                <select class="select2 form-control rounded-0" v-model="form.gender_id">
                                    <option value="">Please Select Gender</option>
                                    <option :value="gender.id" v-for="gender in genders" :key="gender.id">
                                        {{ gender.gender }}
                                    </option>
                                </select>
                                
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Date Of Birth *</label>
                                <input type="date" v-model="form.dob" class="form-control rounded-0">

                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Roll</label>
                                <input type="text" v-model="form.roll_no" placeholder="" class="form-control rounded-0">
                                <button class="btn btn-info btn-sm" @click="generate">Generate</button>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Student Group *</label>
                                <select id="student_group" class="form-control select2 rounded-0" v-model="form.student_group">
                                    <option value="">Please Select Group</option>  
                                    <option v-for="group in student_group" :key="group.id" :value="group.id">{{ group.group_name }}</option>                                              
                                </select>
                            </div>
                       
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Parent *</label>
                                <select v-model="form.parent_id" class="form-control select2 rounded-0">
                                    <option value="">Please Select Parent </option>
                                    <option v-for="parent in parents" :key="parent.id" :value="parent.id">{{ parent.fullname }}</option>
                                </select>
                            </div>
                            
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>E-Mail</label>
                                <input type="email" placeholder="" v-model="form.email" class="form-control rounded-0">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Class *</label>
                                <select class="form-control rounded-0 select2 rounded-0" v-model="form.class_id" >
                                    <option value="">Please Select Class</option>
                                    <option v-for="oneclass in classes" :value="oneclass.id" :key="oneclass.id">{{ oneclass.class_name }}</option>
                                </select>          
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Section *</label>
                                <select v-model="form.section_id" class="form-control select2 rounded-0">
                                    <option value="">Please Select Section *</option>
                                    <option v-for="section in sections" :key="section.id" :value="section.id">{{ section.section_name }}</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Admission Date*</label>
                                <input type="date" v-model="form.admission_date" class="form-control rounded-0">
                            </div>                            
                            
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark rounded-0">Save</button>
                                <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow rounded-0">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="demo">
            <button v-on:click="show = !show">
                Toggle
            </button>
            <transition name="slide-fade">
                <p v-if="show">hello</p>
            </transition>
        </div> 
    </div>
</template>

<script>
import Axios from 'axios';
import { mapState, mapGetters, mapActions } from 'vuex';
import Header from '../inc/Header.vue';


export default {
    name: 'CreateStudent',
    components:{
        Header
    },
    data(){
        return{
            form: {
                class_id: '',
                parent_id: '',
                roll_no: '',
                firstname: '',
                lastname: '',
                gender_id: '',
                admission_date: '',
                dob: '',
                email: '',
                student_group: '',
                section_id: ''
            },
            studentLoad: false,
            show: true
        }
    },
    mounted(){
        this.getParents(),
        this.getGender(),
        this.getClasses(),
        this.fetchSections(),
        this.getGroups()
    },
    computed:{
        ...mapState(['sections', 'classes', 'parents', 'student_group', 'genders']), 
    },
    methods:{
        ...mapActions(['getParents', 'getGender', 'getClasses', 'fetchSections', 'getGroups']),
        addStudent(){
            this.studentLoad = true;
            let formData = new FormData();
            let _fd = this.$data.form;
            Object.entries(_fd).forEach(function(val) {
                formData.append(val[0], val[1]);
            });

            Axios.post('/student/create', formData)
            .then(response => {
                console.log(response);
                let data = response.data;
                if (data.error == true) {
                    $('#msg').text(data.message);
                    $('#error').slideDown(500);
                    setTimeout(() => {  
                        $('#error').slideUp(500);
                    }, 5000);
                    return;
                }
                this.$router.push('students')
            })
            .catch(err => {
                console.log(err);
            })
            .finally(() => {
                this.studentLoad = false
            });
        },
        generate(){
            
        }
    }
}
</script>

<style scoped>
/* Enter and leave animations can use different */
/* durations and timing functions.              */
.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>
