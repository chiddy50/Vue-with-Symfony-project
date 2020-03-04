<template>
    <div class="mt-5">
        <!-- Dashboard summery Start Here -->
        <div class="row gutters-20">
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="dashboard-summery-one mg-b-20">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="item-icon bg-light-green ">
                                <i class="flaticon-classmates text-green"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="item-content">
                                <div class="item-title">Students</div>
                                <div class="item-number" v-if="!countLoader"><span class="counter" :data-num="studentCount" v-text="studentCount"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="dashboard-summery-one mg-b-20">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="item-icon bg-light-blue">
                                <i class="flaticon-multiple-users-silhouette text-blue"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="item-content">
                                <div class="item-title">Teachers</div>
                                <div class="item-number"><span class="counter" data-num="2250">2,250</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="dashboard-summery-one mg-b-20">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="item-icon bg-light-yellow">
                                <i class="flaticon-couple text-orange"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="item-content">
                                <div class="item-title">Parents</div>
                                <div class="item-number" v-if="!countLoader"><span class="counter" :data-num="parentCount" v-text="parentCount"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="dashboard-summery-one mg-b-20">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="item-icon bg-light-red">
                                <i class="flaticon-money text-red"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="item-content">
                                <div class="item-title">Earnings</div>
                                <div class="item-number"><span>$</span><span class="counter" data-num="193000">1,93,000</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dashboard summery End Here -->
        <!-- Dashboard Content Start Here -->
        <div class="row gutters-20">
            <div class="col-12 col-xl-8 col-6-xxxl">
                
            </div>
            <div class="col-12 col-xl-4 col-3-xxxl">
                
            </div>
            <div class="col-12 col-xl-6 col-3-xxxl">
                <div class="card dashboard-card-three pd-b-20">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Students</h3>
                            </div>
                           
                        </div>
                        <div class="doughnut-chart-wrap">
                            <canvas id="student-doughnut-chart" width="100" height="300"></canvas>
                        </div>
                        <div class="student-report">
                            <div class="student-count pseudo-bg-blue">
                                <h4 class="item-title">Female Students</h4>
                                <div class="item-number">{{ femaleCount }}</div>
                            </div>
                            <div class="student-count pseudo-bg-yellow">
                                <h4 class="item-title">Male Students</h4>
                                <div class="item-number">{{ maleCount }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6 col-4-xxxl">
                
            </div>
            <div class="col-lg-6 col-xl-6 col-4-xxxl">
                
            </div>
            <div class="col-lg-6 col-xl-6 col-4-xxxl">
            </div>
        </div>
        <!-- Dashboard Content End Here -->
    </div>    
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';
import Axios from 'axios';

export default {
    name: 'Home',
    mounted(){
        this.countAll()
    },
    computed:{
        ...mapState([
            'parentCount', 
            'studentCount', 
            'countLoader',
            'maleCount',
            'femaleCount'])
    },
    methods: {
        ...mapActions(['countAll']),
        
        
    }

}
</script>
