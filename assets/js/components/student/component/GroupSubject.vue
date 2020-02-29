<template>
    <div class="row">
        <div class="col-sm-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Assign Group a Subject</h3>
                        </div>
                    </div>
                    <form class="new-added-form" @submit.prevent="setGroupSubject">
                        <div class="row">
                            <div class="col-12 form-group">
                                <label>Group Name</label>
                                <select v-model="group_id" class="form-control rounded-0">
                                    <option disabled selected aria-selected>Select Group</option>                                                 
                                    <option v-for="group in student_group" :value="group.id" :key="group.id">
                                        {{ group.group_name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-12 form-group">
                                <label>Subject</label>
                                <select v-model="subject_id" class="form-control rounded-0">
                                    <option disabled selected aria-selected>Select Group</option>                                                 
                                    <option v-for="subject in subjects" :value="subject.id" :key="subject.id">
                                        {{ subject.subject }} ({{ subject.subject_code }})
                                    </option>
                                </select>
                            </div>
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Create</button>
                                <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow" @click="goBack">Back</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-xl-12" v-if="!groupSubjectLoad">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Group Subjects</h3>
                        </div>
                        <div class="">
                            <a href="" @click.prevent="fetchGroupSubject">
                            <i class="fas fa-redo-alt text-orange-peel"></i> 
                            </a>
                        </div>
                    </div>
                
                    <div class="table-responsive" v-if="groupSubjects.length">
                        <table class="table display data-table text-nowrap">
                            <thead>
                                <tr>   
                                    <th>Group</th>                                    
                                    <th>Subject</th>
                                    <th colspan="2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="groupSubject in groupSubjects" :key="`${groupSubject.student_group_id}-${groupSubject.subject_id}`">
                                
                                    <td>{{ groupSubject.group_name|upperCase }}</td>
                                    <td>{{ groupSubject.subject|upperCase }} ({{ groupSubject.subject_code }})</td>
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
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-else class="box">
                        <h6 class="mt-3">No Groups yet</h6>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-12 col-md-12" v-if="groupSubjectLoad">
            <i class="fas fa-spinner fa-spin text-dark text-center"  id="spinner-lg"></i>
        </div>
    </div>
</template>

<script>
import Axios from 'axios';
import { mapState, mapGetters, mapActions } from 'vuex';

export default {
    name: 'GroupSubject',
    data(){
        return{
            subject_id: '',
            group_id: ''
        }
    },
    
    computed:{
       
        ...mapState(['student_group', 'subjects', 'groupSubjects', 'groupSubjectLoad'])
    },
    methods:{
        ...mapActions(['fetchGroupSubject']),
        setGroupSubject(){
            let formData = new FormData();
            formData.append('subject_id', this.subject_id);
            formData.append('group_id', this.group_id);

            Axios.post("/newgroupsubject", formData)
            .then(res => {
                console.log(res);   
                let data = res.data;
                if (data.error === true) {
                    this.$swal(data.message)
                }else{
                    this.$swal(data.message)
                    this.fetchGroupSubject()
                }

            })
            .catch(err => {
                console.error(err);                
            })
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
    .box{
        display: flex;
        align-items: center;
        justify-content: center;
    }

    
</style>