<template>
    <div class="col-lg-12">
        <div class="card dashboard-card-eleven">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Monthly School Attendance</h3>
                    </div>
                    
                </div>
                <div class="table-box-wrap">
                    <form class="search-form-box" @submit.prevent="getMonthlyAttendance($event)">
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
                            <div class="col-lg-2 col-12 form-group">
                                <button type="submit" class="fw-btn-fill btn-gradient-yellow" :disabled="loading">SEARCH</button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="table-responsive result-table-box" v-if="filterRecords.length">
                        <table class="table display data-table table-striped table-bordered text-nowrap">
                            <thead>
                                <tr class="text-center">
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>                            
                                <tr class="text-center" v-for="record in filterRecords" :key="record.id">
                                    <td>{{ record.date }}</td>
                                    <td>{{ record.present }}</td>                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box mt-5 hide">
                        <h2 id="not-found"></h2>
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
import { mapGetters, mapActions, mapState } from 'vuex';
import moment from 'moment';


export default {
    props: ['student_id'],
    data(){
        return{              
            loading: false,  
            form:{
                class_id: '',
                section_id: '',
                month: '',
                session: '',
                my_date: '',
            },
            records: []
        }
    },
    mounted(){
        this.getMonths(),
        this.getSessions()
    },
    computed:{
         ...mapState(['months', 'sessions']),
        
        filterRecords(){
            let records = this.records;
            let newRecord = records.map(record => {
                let present = record.present === true ? 'Present' : 'Absent';
                let date = moment(record.date.date).format('MMMM Do YYYY');
                return {present, date}
            })
            return newRecord;
        }
    },
    methods:{
        ...mapActions(['getSessions', 'getMonths']),
        getMonthlyAttendance(e){
            $('.hide').slideUp(400)
            this.records = []
            this.loading = true
            let fd = new FormData(e.target)
            fd.append('id', this.student_id)

            Axios.post('/monthly-attendance', fd)
            .then(res => {
                this.loading = false

                console.log(res);      
                if(res.data.error){
                    $('.hide').slideDown(500);
                    $('#not-found').text(res.data.message);
                }else{
                    this.records = res.data.records;
                }

            })
            .catch(err => {
                this.loading = false
                console.error(err);                
            })

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

.spinner-md{
    font-size: 50px;
}

.hide{
    display: none;
}
#not-found{
    color: #ff3333;
}

</style>