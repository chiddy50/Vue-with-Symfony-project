<template>
    <div class="col-lg-12">
        <div class="card dashboard-card-eleven">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Check Single Day School Attendance</h3>
                    </div>
                    
                </div>
                <div class="table-box-wrap">
                    <form class="search-form-box" @submit.prevent="getClassAttendanceRecord($event)">
                        <div class="row gutters-8">
                            <div class="col-lg-4 col-12 form-group">
                                <select class="form-control" v-model="form.month" name="month">
                                    <option disabled selected>Select Month</option>
                                    <option v-for="month in months" v-bind="month" :key="month.id" :value="month.id">
                                        {{ month.month }}
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
                            <div class="col-lg-3 col-12 form-group">
                                <input type="date" v-model="form.my_date" class="form-control" name="date">
                            </div>
                            <div class="col-lg-2 col-12 form-group">
                                <button type="submit"
                                    class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
                <div class="box mt-5 present-box">
                    <h3 class="present"></h3>
                </div>
                <div class="box mt-5 absent-box">
                    <h3 class="absent"></h3>
                </div>
                <div class="box mt-5 loading-box" v-if="singelAttendanceLoading">
                    <h3 class="loading">Please wait....</h3>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import Axios from 'axios';
import { mapGetters, mapActions, mapState } from 'vuex';

export default {
    name: 'CheckSingleAttendance',
    props:['student_id'],
    data(){
        return{                
            form:{
                class_id: '',
                section_id: '',
                month: '',
                session: '',
                my_date: '',
            },
            singelAttendanceLoading: false
        }
    },
    mounted(){
        this.getMonths(),
        this.getSessions()
    },
    computed:{
         ...mapState(['months', 'sessions']),
    },
    methods:{
        ...mapActions(['getMonths', 'getSessions']),
        getClassAttendanceRecord(e){
            this.singelAttendanceLoading = true;
            $('.present-box').hide();
            $('.absent-box').hide();
            let fd = new FormData(e.target);
            fd.append('id', this.student_id);

            Axios.post('/student/single-attendance', fd)
            .then(res => {
                this.singelAttendanceLoading = false;
                let data = JSON.parse(res.data);                
                if(data.error){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }else{
                    if (data.attendance) {
                        $('.present').text('Student was present');              
                        $('.present-box').slideDown(500);
                    }else{
                        $('.absent').text('Student was Absent');
                        $('.absent-box').slideDown(500);
                    }
                }
            })
            .catch(err => console.error(err) )
            .finally(() => this.singelAttendanceLoading = false );
        }
    },
    filters:{
        upper(val){
            return val.toUpperCase();
        }
    }
}
</script>

<style scoped>
.box{
    display: flex;
    justify-content: center;
    align-items: center;   
}

.present-box, .absent-box{
    display: none;
}

.absent{
    color: #ff3333;
}
.present{
    color: #2bca33;
}
</style>