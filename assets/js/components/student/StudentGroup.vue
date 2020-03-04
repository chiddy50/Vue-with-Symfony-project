<template>
    <div>
        <div class="row">
            <Header :title="'Students'" :title2="'Student Group'"/>
        </div>
        
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="row">
                    <div class="col-lg-8 offset-2 col-sm-12">
                        <div class="card dashboard-card-eleven">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Add Student Group</h3>
                                </div>                            
                            </div>
                            <div class="table-box-wrap">
                                <form @submit.prevent="creategroup($event)" class="search-form-box">
                                    <div class="row gutters-8">
                                        <div class="col-lg-6 col-6 form-group">
                                            <input type="text" v-model="group_name" name="group_name" placeholder="Group Name" class="form-control">
                                        </div>                          
                                        <div class="col-lg-3 col-3 form-group">
                                            <button type="submit" class="fw-btn-fill btn-gradient-yellow" :disabled="groupLoading">{{ btnText }}</button>
                                        </div>
                                        <div class="col-lg-3 col-3 form-group">
                                            <button @click.prevent="resetForm" class="fw-btn-fill btn-info">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card height-auto">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Student Groups</h3>
                                    </div>
                                </div>
                            
                                <div class="table-responsive">
                                    <table class="table display data-table table-striped table-bordered text-nowrap">
                                        <thead>
                                            <tr>   
                                                <th>Group Name</th>                                    
                                                <th colspan="4"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(group, index) in student_group" :key="group.id">                                            
                                                <td class="text-uppercase">{{ group.group_name }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-lg shadow-dark-peel bg-danger rounded-bottom text-light" @click="deleteGroup(group.id, index, $event)">
                                                        <i class="fas fa-trash text-light"></i> 
                                                    </button>
                                                    <i class="fas fa-spinner fa-spin text-danger spinner-sm"></i>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-lg shadow-dark-peel bg-success rounded-bottom text-light" @click="editGroup(group)">
                                                        <i class="fas fa-pencil-alt text-light"></i> 
                                                    </button>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-lg shadow-dark-peel bg-warning rounded-bottom text-light modal-trigger" @click="getGroupSubjects(group.id, group.group_name)" data-toggle="modal" data-target="#view-modal">
                                                        <i class="fas fa-book text-light"></i> View Subjects
                                                    </button>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-lg shadow-dark-peel bg-primary rounded-bottom text-light modal-trigger" @click="setGroupId(group.id, group.group_name)" data-toggle="modal" data-target="#large-modal">
                                                        <i class="fas fa-book text-light"></i> Add Subject
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Add Modal Starts Here -->
            <div class="modal fade" id="large-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Subjects for {{ name }}</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="addSubjectToGroup($event)">
                            <div class="modal-body">                                
                                
                                <div class="row gutters-8">
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="alert alert-success alert-dismissible fade show" id="success-msg" role="alert">
                                            <span class="success-msg"></span>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="alert alert-danger alert-dismissible fade show" id="error-msg" role="alert">
                                            <span class="error-msg"></span>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row gutters-8">
                                    <div class="col-sm-12 col-md-6 col-lg-4" v-for="(subject, index) in subjects" :key="index">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" >
                                                    <input type="checkbox" :disabled="inArray(subject.id, subject_ids)" :checked="inArray(subject.id, subject_ids)" :name="'subject['+subject.subject+']'" :value="subject.id">
                                                </div>
                                            </div>
                                            <input type="text" disabled class="form-control" :placeholder="subject.subject">
                                        </div>                                
                                    </div>
                                </div>                                                    
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="footer-btn bg-dark-low"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" :disabled="addSubjectGroupLoad" class="footer-btn bg-linkedin">
                                    Add Subjects <i v-if="addSubjectGroupLoad" class="fas fa-spinner fa-spin text-light text-center"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <!-- Add Modal ends here -->

        <!-- View Modal Starts here -->
            <div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ name }} Subjects</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">                                                                                     
                            
                            <div class="row gutters-8">
                                <div v-for="(subject, index) in groupSubjects" :key="index" class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" >
                                                <input type="checkbox" class="subject-checkbox">
                                            </div>
                                        </div>
                                        <input type="text" disabled class="form-control" :value="subject.subject">
                                    </div>                                
                                </div>
                            </div> 
                            <hr>
                            <input type="checkbox" @click="selectAll($event)" id="defaultCheck">
                            <label for="defaultCheck">Select All</label>    

                            <button class="btn btn-lg shadow-dark-peel bg-danger rounded-bottom text-light ml-4" @click="deleteSubjectGroup(subject.id)">
                                <i class="fas fa-trash text-light"></i> Delete
                            </button>                                           
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="footer-btn bg-dark-low"
                                data-dismiss="modal">Close</button>
                            <!-- <button type="submit" class="footer-btn bg-linkedin">Add Subjects</button> -->
                        </div>
                    </div>
                </div>
            </div>
        <!-- View Modal ends here -->
    </div>
</template>

<script>
import Axios from 'axios';
import { mapState, mapGetters, mapActions } from 'vuex';
import Header from '../inc/Header.vue';

export default {
    name: 'StudentGroup',
    components:{
        Header
    },
    data(){
        return{
            id: null,
            group_name: null,
            groupLoading: false,  
            addSubjectGroupLoad: false,          
            edit: false,
            subject_ids: [],
            group_id: null,
            name: null,
            groupSubjects: []       
        }
    },

    mounted(){
        this.getGroups(),
        this.fetchSubjects(),
        this.fetchGroupSubject()
    },
    computed:{
        ...mapState(['student_group', 'subjects']),
        btnText(){
           return this.edit === true ? 'Edit' : 'Create';
        },
        subjectIds(){
            let id = this.groupSubjects.map(subject => {
                return subject.id
            });
            return id;
        }
    },
    methods:{
        ...mapActions(['getGroups', 'fetchSubjects', 'fetchGroupSubject', 'spliceStudentGroup']),
        creategroup(e){
            if(this.edit){
                this.groupLoading = true;
                let formData = new FormData(e.target);
                formData.append('id', this.id)
                Axios.post('/edit-student-group', formData)
                .then(response => {
                    console.log(response);
                    let data = JSON.parse(response.data);
                    if (data.error) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }else{
                        this.$store.state.student_group = data.student_groups
                        this.resetForm()
                    }
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.groupLoading = false;
                    this.resetForm()
                })
            }else{
                this.groupLoading = true;
                let formData = new FormData(e.target);
    
                Axios.post('/new-student-group', formData)
                .then(response => {
                    console.log(response);
                    let data = JSON.parse(response.data);
                    if (data.error) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }else{
                        this.group_name = ''
                        this.$store.state.student_group = [...this.student_group, data.student_group]
                    }
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.groupLoading = false;
                })
            }
        },
        deleteGroup(id, index, e){
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
                Axios.post('/delete-student-group', fd)
                .then(res => {
                    let data = JSON.parse(res.data);
                    if (data.error) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }else{
                        this.spliceStudentGroup(index);  
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
        editGroup(group){
            this.edit = true
            this.id = group.id;
            this.group_name = group.group_name
        },
        addSubjectToGroup(e){
            this.addSubjectGroupLoad = true
            $('.success-msg').text('');
            $('.error-msg').text('');
            let fd = new FormData(e.target);
            fd.append('group_id', this.group_id);
            Axios.post('/new-subject-group', fd)
            .then(res => {
                this.addSubjectGroupLoad = false
                let data = JSON.parse(res.data);
                if (data.error) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }else{                    
                    let existingSubjects = data.exists;
                    let non_existingSubjects = data.non;
                    if (existingSubjects.length) {
                        $("div#error-msg").show(500);
                        if (existingSubjects.length === 1) {
                            $('.error-msg').text(`${existingSubjects.join(". ")} is being offered by this group already`);                                                    
                        }else{
                            $('.error-msg').text(`${existingSubjects.join(", ")} are being offered by this group already`);
                        }
                    }
                    
                    if(non_existingSubjects.length > 0){
                        $("div#success-msg").show(500);
                        if (non_existingSubjects.length === 1) {
                            $('.success-msg').text(`${non_existingSubjects.join(". ")} was added`);                                                     
                        }else{
                            $('.success-msg').text(`${non_existingSubjects.join(", ")} were added`); 
                        }
                        
                    }
                    setTimeout(() => {
                        $("div#success-msg").slideUp(500);                        
                        $("div#error-msg").slideUp(500);                        
                    }, 10000);                                    
                }
                
            })
            .catch(err => console.error(err))
            .finally(() => { this.addSubjectGroupLoad = false });
        },
        getGroupSubjects(id, name){
            this.groupSubjects = [];
            this.group_id = id;
            this.name = name;
            let fd = new FormData;
            fd.append('group_id', id)
            Axios.post('/get-group-subjects', fd)
            .then(res => {
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
                    this.groupSubjects = data.subjects;
                    
                }      
            })
            .catch(err => console.error(err))
            .finally(() => {}) 
        },
        deleteSubjectGroup(subject_id){

        },
        selectAll(e){
            let checkboxes = document.querySelectorAll("input.subject-checkbox");
            if (e.target.checked) {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = true;
                });                
            }else{
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                }); 
            }
        },
        resetForm(){
            this.edit = false
            this.id = ''
            this.group_name = ''
        },
        returnToPreviousPage(){
            window.history.length > 1
            ? this.$router.go(-1)
            : this.$router.push('/')
        },        
        setGroupId(id, group_name){
            this.group_id = id;
            this.name = group_name;
            let fd = new FormData;
            fd.append('group_id', id)
            Axios.post('/get-group-subjects', fd)
            .then(res => {
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
                    this.groupSubjects = data.subjects;
                    this.subject_ids = data.subject_ids;
                }      
            })
            .catch(err => console.error(err))
            .finally(() => {})
        },
        inArray(needle, haystack) {
            // var length = haystack.length;
            // for(var i = 0; i < length; i++) {
            //     if(haystack[i] == needle) return true;
            // }
            // return false; 

            // OR
            var value = haystack.some(val => {
               return val == needle 
            });

            return value;

        }
        
    }

}
</script>

<style scoped>
i.spinner-sm{
    display: none !important;
}

div#success-msg{
    display: none;
}
div#error-msg{
    display: none;
}

.flex{
    display: flex;
    align-items: center;
    justify-content: center;
}

.spinner{
    font-size: 50px;
}
</style>