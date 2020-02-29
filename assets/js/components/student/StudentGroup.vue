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
                                                <th colspan="3"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(group, index) in student_group" :key="group.id">                                            
                                                <td>{{ group.group_name|upperCase }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-lg shadow-dark-peel bg-danger rounded-bottom text-light" @click="deleteGroup(group.id, index, $event)">
                                                        <i class="fas fa-trash text-light"></i> Delete
                                                    </button>
                                                    <i class="fas fa-spinner fa-spin text-danger spinner-sm"></i>
                                                </td>
                                                <td>
                                                    <button class="btn btn-lg shadow-dark-peel bg-success rounded-bottom text-light" @click="editGroup(group)">
                                                        <i class="fas fa-cogs text-light"></i> Edit
                                                    </button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-lg shadow-dark-peel bg-primary rounded-bottom text-light">
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
            <div class="col-lg-12 col-sm-12">
                <GroupSubject/>
            </div>
        </div>
        
    </div>
</template>

<script>
import Axios from 'axios';
import { mapState, mapGetters, mapActions } from 'vuex';
import GroupSubject from './component/GroupSubject.vue'
import Header from '../inc/Header.vue';

export default {
    name: 'StudentGroup',
    components:{
        GroupSubject,
        Header
    },
    data(){
        return{
            id: '',
            group_name: '',
            groupLoading: false,            
            edit: false            
        }
    },

    mounted(){
        this.getGroups(),
        this.fetchSubjects(),
        this.fetchGroupSubject()
    },
    computed:{
        ...mapState(['student_group']),
        btnText(){
           return this.edit === true ? 'Edit' : 'Create';
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
                        Swal.fire('Error!', data.message, 'error')
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
                        Swal.fire('Error!', data.message, 'error')
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
                        Swal.fire('Error!', data.message, 'error')
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
        goBack(){
            this.returnToPreviousPage();
        }
    },
    filters:{
        upperCase(val){
            return val.toUpperCase()
        }
    }

}
</script>

<style scoped>
i.spinner-sm{
    display: none !important;
}
</style>