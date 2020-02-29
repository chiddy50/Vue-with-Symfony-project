<template>
    <div class="row mt-5">
        <Header :title="'Subject'" :title2="'Add New Subject'"/>

        <div class="col-sm-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Create A Subject</h3>
                        </div>                        
                    </div>                    
                    <form class="new-added-form" @submit.prevent="createSubject($event)">
                        <div class="row">
                            <div class="col-12-xxxl col-lg-4 col-12 form-group">
                                <label>Subject Name</label>                                
                                <input type="text" v-model="form.subject_name" name="subject_name" class="form-control rounded-0">
                            </div>
                            <div class="col-12-xxxl col-lg-4 col-12 form-group">
                                <label>Subject Code</label>
                                <input type="text" v-model="form.subject_code" name="subject_code" class="form-control rounded-0">
                            </div>
                            <div class="col-12-xxxl col-lg-4 col-12 form-group">                        
                                <label>Subject Type</label>
                                <select v-model="form.subject_type" name="subject_type" class="form-control rounded-0">
                                    <option disabled>Please Select Type *</option>
                                    <option v-for="type in subjectTypes" :key="type.id" :value="type.id">{{ type.subject_type }}</option>
                                </select>
                            </div>
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" :disabled="subjectLoad">{{btnText}}</button>
                                <button @click.prevent="resetForm" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>All Subjects</h3>
                        </div>                        
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table display data-table table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Code</th>                                    
                                    <th>Type</th>
                                    <th colspan="2"></th>                                    
                                </tr>
                            </thead>
                            <tbody v-if="!subjectLoading">
                                <tr v-for="(subject, index) in subjects" :key="subject.id">                                   
                                    <td>{{ subject.subject }}</td>
                                    <td>{{ subject.subject_code }}</td>  
                                    <td>{{ subject.subject_type.subject_type }}</td>                                  
                                    <td class="text-center">
                                        <button class="btn btn-lg shadow-dark-peel bg-danger rounded-bottom text-light" @click="deleteSubject(subject.id, index, $event)">
                                            <i class="fas fa-trash text-light"></i> 
                                        </button>
                                        <i class="fas fa-spinner fa-spin text-danger spinner-sm"></i>
                                    </td>
                                    <td>
                                        <button class="btn btn-lg shadow-dark-peel bg-success rounded-bottom text-light" @click="editSubject(subject)">
                                            <i class="fas fa-cogs text-light"></i> 
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                                <tr class="text-center" v-else>
                                    <td>
                                        <i class="fas fa-spinner fa-spin text-warning"  id="spinner-md"></i>
                                    </td>
                                    <td>
                                        <i class="fas fa-spinner fa-spin text-warning"  id="spinner-md"></i>
                                    </td>
                                    <td>
                                        <i class="fas fa-spinner fa-spin text-warning"  id="spinner-md"></i>
                                    </td>
                                    <td>
                                        <i class="fas fa-spinner fa-spin text-warning"  id="spinner-md"></i>
                                    </td>                               
                                </tr>
                        </table> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Create A Subject Type</h3>
                </div>                            
            </div>
            <div class="card dashboard-card-eleven">
                <div class="table-box-wrap">
                    <form @submit.prevent="createSubjectType($event)" class="search-form-box">
                        <div class="row gutters-8">
                            <div class="col-md-6 col-sm-12 col-12 form-group">
                                <input type="text" v-model="subject_type" name="subject_type" placeholder="Subject Type..." class="form-control rounded-0">
                            </div>
                            <div class="col-md-3 col-sm-6 col-12 form-group">
                                <button type="submit" :disabled="subjectTypeLoad" class="fw-btn-fill btn-gradient-yellow">{{btnText2}}</button>
                            </div>                            
                            <div class="col-md-3 col-sm-6 col-12 form-group">
                                <button @click.prevent="resetTypeForm" class="fw-btn-fill btn-info btn-hover-yellow">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-lg-6 col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>All Subject Types</h3>
                        </div>                        
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table display data-table table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>                                    
                                    <th>Subject Type</th>
                                    <th colspan="2"></th>
                                    
                                </tr>
                            </thead>
                            <tbody v-if="!subjectTypeLoading">
                                <tr v-for="(subject, index) in subjectTypes" :key="subject.id">                                   
                                    <td>{{ subject.subject_type }}</td>                                    
                                    <td class="text-center">
                                        <button class="btn btn-lg shadow-dark-peel bg-danger rounded-bottom text-light" @click="deleteType(subject.id, index, $event)">
                                            <i class="fas fa-trash text-light"></i> Delete
                                        </button>
                                        <i class="fas fa-spinner fa-spin text-danger spinner-sm"></i>
                                    </td>
                                    <td>
                                        <button class="btn btn-lg shadow-dark-peel bg-success rounded-bottom text-light" @click="editType(subject)">
                                            <i class="fas fa-cogs text-light"></i> Edit
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tr v-else>
                                <td>
                                    <i class="fas fa-spinner fa-spin text-warning text-center"  id="spinner-md"></i>
                                </td>
                                <td>
                                    <i class="fas fa-spinner fa-spin text-warning text-center"  id="spinner-md"></i>
                                </td>
                                <td>
                                    <i class="fas fa-spinner fa-spin text-warning text-center"  id="spinner-md"></i>
                                </td>                               
                            </tr>
                        </table> 
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Axios from 'axios';
import { mapGetters, mapActions, mapState } from 'vuex';
import Header from '../inc/Header.vue';

export default {
    name: 'Classes',
    components:{
        Header
    },
    data(){
        return{
            form: {
                id: '',
                subject_name: '',
                subject_code: '',
                subject_type: '',
            },
            type_id: '',
            subject_type: '',
            subjectLoad: false,
            subjectTypeLoad: false,
            edit: false,
            type_edit: false
        }
    },
    mounted(){
        this.fetchSubjects(), 
        this.fetchSubjectTypes()
    },
    computed:{
        ...mapState(['subjects', 'subjectLoading', 'subjectTypes', 'subjectTypeLoading']),
        btnText(){
           return this.edit === true ? 'Edit' : 'Create';
        },
        btnText2(){
           return this.type_edit === true ? 'Edit' : 'Create';
        }
    },
    methods:{
        ...mapActions(['fetchSubjects', 'fetchSubjectTypes', 'spliceSubject', 'spliceSubjectType']),
        createSubject(e){
            if (this.edit === false) {
                this.subjectLoad = true;
                let formData = new FormData(e.target);
                
                Axios.post('/new-subject', formData)
                .then(response => {
                    let data = JSON.parse(response.data);
                    if (data.error) {
                        Swal.fire('Error!', data.message, 'error')
                    }else{
                        this.$store.state.subjects = [...this.subjects, data.subject]
                    }
                })
                .catch(err => {
                    console.log(err)
                })
                .finally(() => {
                    this.subjectLoad = false
                })
            }else{
                this.subjectLoad = true;
                let formData = new FormData(e.target);
                formData.append('id', this.form.id)
                Axios.post('/edit-subject', formData)
                .then(response => {
                    let data = JSON.parse(response.data);
                    if (data.error) {
                        Swal.fire('Error!', data.message, 'error')
                    }else{
                        this.edit = false
                        this.$store.state.subjects = data.subjects
                    }
                })
                .catch(err => {
                    console.log(err)
                })
                .finally(() => {
                    this.subjectLoad = false
                    this.resetForm()
                })
            }
        },
        createSubjectType(e){
            if (this.type_edit === false) {
                this.subjectTypeLoad = true;
                let formData = new FormData(e.target);
                
                Axios.post('/new-subtype', formData)
                .then(response => {
                    let data = JSON.parse(response.data);
                    if (data.error) {
                        Swal.fire('Error!', data.message, 'error');
                    }else{
                        this.$data.subject_type = '';
                        this.$store.state.subjectTypes = [...this.$store.state.subjectTypes, data.type] 
                    }
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.subjectTypeLoad = false;
                })
            }else{
                this.subjectTypeLoad = true;
                let formData = new FormData(e.target);
                formData.append('id', this.type_id)
                formData.append('subject_type', this.subject_type)
                Axios.post('/edit-type', formData)
                .then(response => {
                    console.log(response);
                    let data = JSON.parse(response.data);
                    if (data.error) {
                        Swal.fire('Error!', data.message, 'error');
                    }else{
                        this.$store.state.subjectTypes = data.types
                        this.$data.subject_type = '';
                        this.type_edit = false
                    }
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.subjectTypeLoad = false;
                    this.resetTypeForm()
                })
            }
        },
        deleteSubject(id, index, e){
            if (confirm('Are you sure?')) {
                var target, spinner;
                if (e.target.classList.contains('bg-danger')) {
                    target = e.target;
                    target.hidden = true;
                    spinner = e.target.nextElementSibling;
                    spinner.classList.remove('spinner-sm');
                }else if (e.target.classList.contains('fa-trash')) {
                    target = e.target.parentElement;
                    target.hidden = true;
                    spinner = e.target.parentElement.nextElementSibling;
                    spinner.classList.remove('spinner-sm');
                }
    
                let fd = new FormData;
                fd.append('id', id)
                Axios.post('/delete-subject', fd)
                .then(res => {
                    let data = JSON.parse(res.data);
                    if (data.error) {
                        Swal.fire('Error!', data.message, 'error')
                    }else{
                        this.spliceSubject(index);  
                    }      
                })
                .catch(err => {
                    console.error(err);
                })
                .finally(() => {
                    target.hidden = false;
                    spinner.classList.add('spinner-sm');
                })                
            }
        },
        editSubject(subject){
            this.edit = true
            this.form.id = subject.id;
            this.form.subject_name = subject.subject
            this.form.subject_code = subject.subject_code
            this.form.subject_type = subject.subject_type.id

        },
        editType(type){
            this.type_edit = true
            this.type_id = type.id
            this.subject_type = type.subject_type
        },
        deleteType(id, index, e){
            if (confirm('Are you sure?')) {
                var target, spinner;
                if (e.target.classList.contains('bg-danger')) {
                    target = e.target;
                    target.hidden = true;
                    spinner = e.target.nextElementSibling;
                    spinner.classList.remove('spinner-sm');
                }else if (e.target.classList.contains('fa-trash')) {
                    target = e.target.parentElement;
                    target.hidden = true;
                    spinner = e.target.parentElement.nextElementSibling;
                    spinner.classList.remove('spinner-sm');
                }
    
                let fd = new FormData;
                fd.append('id', id)
                Axios.post('/delete-type', fd)
                .then(res => {
                    let data = JSON.parse(res.data);
                    if (data.error) {
                        Swal.fire('Error!', data.message, 'error')
                    }else{
                        this.spliceSubjectType(index);  
                    }      
                })
                .catch(err => {
                    console.error(err);
                })
                .finally(() => {
                    target.hidden = false;
                    spinner.classList.add('spinner-sm');
                })                
            }
        },
        resetForm(){
            this.edit = false
            this.form.id = ''
            this.form.subject_name = ''
            this.form.subject_code = ''
            this.form.subject_type = ''
        },
        resetTypeForm(){
            this.type_edit = false,
            this.subject_type = ''
        },
        returnToPreviousPage(){
            window.history.length > 1
            ? this.$router.go(-1)
            : this.$router.push('/')
        },
        goBack(){
            this.returnToPreviousPage();
        }
        
    }
}
</script>

<style scoped>

i.spinner-sm{
    display: none !important;
}
</style>
