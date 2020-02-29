<template>
        <div class="row">
    
        <Header :title="'Student'" :title2="'Edit Student'"/>

        <div class="col-sm-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Edit Student</h3>
                        </div>                        
                    </div>
                    

                    <form class="new-added-form" data-select2-id="18" @submit.prevent="editStudent">
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
                                <select class="select2 form-control rounded-0" v-model="form.gender">
                                    <option value="">Please Select Gender</option>
                                    <option :value="gender.id" v-for="gender in genders" :key="gender.id">
                                        {{ gender.gender }}
                                    </option>
                                </select>
                                
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Date Of Birth *</label>
                                <datepicker v-if="!dateLoading" :format="formatter" :bootstrap-styling="true" :value="form.dob" v-model="form.dob" name="dob"></datepicker>
                                <input v-else type="text" class="form-control rounded-0" disabled placeholder="Please wait, Loading date...">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Roll</label>
                                <input type="text" v-model="form.roll_no" disabled placeholder="" class="form-control rounded-0">
                                <!-- <button class="btn btn-info btn-sm" @click="generate">Generate</button> -->
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
                                <select v-model="form.parent" class="form-control select2 rounded-0">
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
                                <select class="form-control rounded-0 select2 rounded-0" v-model="form.class_name" >
                                    <option value="">Please Select Class</option>
                                    <option v-for="oneclass in classes" :value="oneclass.id" :key="oneclass.id">{{ oneclass.class_name }}</option>
                                </select>          
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Section *</label>
                                <select v-model="form.section" class="form-control select2 rounded-0">
                                    <option value="">Please Select Section *</option>
                                    <option v-for="section in sections" :key="section.id" :value="section.id">{{ section.section_name }}</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Admission Date*</label>
                                <datepicker v-if="!dateLoading" :format="formatter" :bootstrap-styling="true" :value="form.admission_date" v-model="form.admission_date" name="doa"></datepicker>
                                <input v-else type="text" class="form-control rounded-0" disabled placeholder="Please wait, Loading date...">
                            </div>                            
                            
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" :disabled="editLoading" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark rounded-0">Update</button>
                                <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow rounded-0">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
       
    </div>
</template>

<script>
import Axios from 'axios';
import { mapState, mapGetters, mapActions } from 'vuex';
import Datepicker from 'vuejs-datepicker';
import Header from '../inc/Header.vue';


export default {
    name: 'EditStudent',
    components:{
        Datepicker,
        Header
    },
    data(){
        return {
            form:{
                id: '',
                firstname: '',
                lastname: '',
                email: '',
                roll_no: '',
                dob: '',
                gender: '',
                admission_date: '',
                parent: '',
                class_name: '',
                student_group: '',
                section: ''
            },
            dateLoading: false,
            editLoading: false
        }
    },
    props: ['student'],
    computed:{
        ...mapState(['sections', 'classes', 'parents', 'student_group', 'genders'])
    },
    beforeMount(){
        this.getStudentsDates()
        this.fillForm()
    },
    methods:{
        ...mapActions(['getParents', 'getGender', 'getClasses', 'fetchSections', 'getGroups']),
        getStudentsDates(){
            this.dateLoading = true
            let formData = new FormData();
            let self = this;
            formData.append('id', this.student.id)
            Axios.post('/get-student-dates', formData)
            .then(response => {
                let data = response.data;
                this.form.admission_date = data.doa.date;
                this.form.dob = data.dob.date;        
            })
            .catch(err => {
                console.log(err)
            })
            .finally(() => this.dateLoading = false )
        },
        editStudent(){
            this.editLoading = true
            let formData = new FormData()
            let data = this.$data.form;
            Object.entries(data).forEach(function(val) {
                formData.append(val[0], val[1]);
            }); 
            Axios.post('/edit-student', formData)
            .then(response => {
                this.editLoading = false
                let data = response.data;
                if (data.error === false) {                         
                    this.$router.push('/students')
                }                
            })
            .catch(err => {
                console.error(err)                
            })
            .finally(() => this.editLoading = false)
        },
        fillForm(){
            this.form.id = this.student.id
            this.form.firstname = this.student.firstname
            this.form.lastname = this.student.lastname
            this.form.email = this.student.email
            this.form.roll_no = this.student.roll_no
            this.form.gender = this.student.gender.id
            this.form.parent = this.student.parent.id
            this.form.class_name = this.student.classes.id
            this.form.student_group = this.student.student_group.id
            this.form.section = this.student.section.id
        },
        formatter(date) {
            return moment(date).format('MMMM-Do-YYYY');
        },
    }
}
</script>

<style>

</style>
