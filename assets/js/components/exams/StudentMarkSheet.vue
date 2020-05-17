<template>
    <div class="row">
        <Header :title="'Search for Student by Class & Section'" :title2="'Student Mark Sheet'"/>
        <div class="col-sm-12 col-md-8">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Search for students</h3>
                        </div>                        
                    </div>
                    
                    <form @submit.prevent="searchStudent($event)" class="new-added-form">
                        <div class="row">
                            <div class="col-6-xxxl col-lg-6 col-12 form-group">
                                <label>Choose Class</label>
                                <select v-model="form.class_id" name="class_id" class="form-control">
                                    <option aria-placeholder="Choose Class" selected disabled>Choose Class</option>
                                    <option :value="myclass.id" v-for="myclass in classes" :key="myclass.id" class="text-uppercase">{{ myclass.class_name }}</option>
                                </select>
                            </div>
                            <div class="col-6-xxxl col-lg-6 col-12 form-group">
                                <label>Choose Section</label>
                                <select v-model="form.section_id" name="section_id" class="form-control">
                                    <option aria-placeholder="Choose Section" selected disabled>Choose Section</option>
                                    <option name="section_id" :value="section.id" v-for="section in sections" :key="section.id" class="text-uppercase">{{ section.section_name }}</option>
                                </select>
                            </div>
                            
                            <div class="col-12 form-group mg-t-8">
                                <button :disabled="$store.state.studentsLoading" type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-10 offset-1 col-sm-12" v-if="watchLoading">
            <div class="box">
                <h3 class="loading text-primary">Please wait....</h3>
            </div>
        </div>

        <StudentMarkSheetTable v-if="students.length"/>
    </div>
</template>

<script>
import Axios from 'axios';
import Header from '../inc/Header.vue';
import StudentMarkSheetTable from './StudentMarkSheetTable.vue';
import { mapActions, mapState } from 'vuex';

export default{
    name: 'StudentMarkSheet',
    components:{
        Header,
        StudentMarkSheetTable
    },
    data(){
        return{
            form:{
                class_id: '',
                section_id: ''
            },
            className: '',
            sectionName: ''
        }
    },
    mounted(){
        this.fetchSections(),
        this.getClasses()
    },
    computed:{
        ...mapState(['classes', 'sections', 'students', 'data']),
        watchLoading(){
            return this.$store.state.classLoading === true || this.$store.state.sectionLoading === true || this.$store.state.studentsLoading ? true : false;
        }
    },
    methods:{
        ...mapActions(['getClasses', 'fetchSections', 'getTerms', 'searchStudent']),

    }

}
</script>

<style scoped>
.box{
    display: flex;
    justify-content: center;
    align-items: center;   
}
</style>