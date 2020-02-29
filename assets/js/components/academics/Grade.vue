<template>
    <div class="row">
        <Header :title="'Examination'" :title2="'Exam Grade'"/>

        <div class="col-4-xxxl col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Add New Grade</h3>
                        </div>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-expanded="false">...</a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-times text-orange-red"></i>Close</a>
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                            </div>
                        </div>
                    </div>
                    <form @submit.prevent="addGrade($event)" class="new-added-form">
                        <div class="row">
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Grade Name</label>
                                <input type="text" name="grade" class="form-control">
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Grade Description</label>
                                <input type="text" name="description" class="form-control">
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Percentage From</label>
                                <input type="text" name="percent_from" class="form-control">
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Percentage Upto</label>
                                <input type="text" name="percent_upto" class="form-control">
                            </div>
                            <div class="col-12 form-group">
                                <label>Comments</label>
                                <textarea class="textarea form-control" name="comment" cols="10" rows="4"></textarea>
                            </div>
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" :disabled="gradeLoading" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                                <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
 
        <div class="col-8-xxxl col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Exam Grade Lists</h3>
                        </div>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-expanded="false">...</a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-times text-orange-red"></i>Close</a>
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                            </div>
                        </div>
                    </div>
                    <form class="mg-b-20">
                        <div class="row gutters-8">
                            <div class="col-lg-5 col-sm-4 col-12 form-group">
                                <input type="text" placeholder="Search by Grade ..." class="form-control">
                            </div>
                            <div class="col-lg-5 col-sm-5 col-12 form-group">
                                <input type="text" placeholder="Search by Point ..." class="form-control">
                            </div>
                            <div class="col-lg-2 col-sm-3 col-12 form-group">
                                <button type="submit"
                                    class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Grade Name</th>
                                    <th>Description</th>
                                    <th>Percent From</th>
                                    <th>Percent Upto</th>
                                    <th>Comment</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="grade in grades" :key="grade.id">
                                    <td>{{ grade.grade }}</td>
                                    <td>{{ grade.description }}</td>
                                    <td>{{ grade.percent_from }}</td>
                                    <td>{{ grade.percent_upto}}</td>
                                    <td>{{ grade.comment }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false">
                                                <span class="flaticon-more-button-of-three-dots"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#"><i
                                                        class="fas fa-times text-orange-red"></i>Close</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>                                         
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2'
import Header from '../inc/Header.vue';
import Axios from 'axios'
import { mapActions, mapState } from 'vuex';

export default {
    name: 'Grade',
    data(){
        return{
            gradeLoading: false,
        }
    },
    components:{
        Header
    },
    created(){
        this.getGrades()
    },
    computed: {
        ...mapState(['grades'])
    },
    methods: {
        ...mapActions(['getGrades']),

        addGrade(e){
            this.gradeLoading = true
            let fd = new FormData(e.target)
            Axios.post('/grade/new', fd)
            .then(res => {
                this.gradeLoading = false
                console.log(res); 
                if (res.data.error) {
                    Swal.fire('Error!', res.data.message, 'error')    
                }         
                this.grades.push(res.data.grade)
            })
            .catch(err => {
                this.gradeLoading = false
                Swal.fire('Error!', 'There was an error getting the grades', 'error')    
                console.error(err);                
            })
        }
    }
}
</script>

<style>

</style>