<template>
    <div class="row mt-5">
        <Header :title="'Sections'" :title2="'Add New Section'"/>

        <div class="col-md-10 offset-1">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Create A Section</h3>
                        </div>                      
                    </div>
                    
                    <form class="new-added-form" @submit.prevent="createSection($event)">
                        <div class="row">
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Section Name</label>
                                <input type="text" v-model="section_name" name="section_name" class="form-control rounded-0">
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Section Code</label>
                                <input type="text" v-model="section_code" name="section_code" class="form-control rounded-0">
                            </div>
                            
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" :disabled="sectionLoading">{{btnText}}</button>                                
                                <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow" @click="goBack">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-10 offset-1">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>All Sections</h3>
                        </div>                       
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table display data-table table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>                                    
                                    <th>Section Name</th>
                                    <th>Section Code</th>                                    
                                    <th colspan="2"></th>
                                </tr>
                            </thead>
                            <tbody v-if="!sectionsLoading">
                                <tr v-for="(section, index) in sections" :key="section.id">                                   
                                    <td>{{ section.section_name }}</td>
                                    <td>{{ section.section_code }}</td>                                    
                                    <td class="text-center">
                                        <button class="btn btn-lg shadow-dark-peel bg-danger rounded-bottom text-light" @click="deleteSection(section.id, index, $event)">
                                            <i class="fas fa-trash text-light"></i> 
                                        </button>
                                        <i class="fas fa-spinner fa-spin text-danger spinner-sm"></i>
                                    </td>
                                    <td>
                                        <button class="btn btn-lg shadow-dark-peel bg-success rounded-bottom text-light" @click="editSection(section)">
                                            <i class="fas fa-cogs text-light"></i> 
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tr v-else>
                                <td>
                                    <i class="fas fa-spinner fa-spin text-warning text-center spinner"></i>
                                </td>
                                <td>
                                    <i class="fas fa-spinner fa-spin text-warning text-center spinner"></i>
                                </td>
                                <td>
                                    <i class="fas fa-spinner fa-spin text-warning text-center spinner"></i>
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
    name: 'Sections',
    components:{
        Header
    },
    data(){
        return{
            id: '',
            section_name: '',
            section_code: '',
            sectionLoading: false,
            edit: false
        }
    },
    mounted(){
        this.fetchSections();
    },
    computed:{
        ...mapState(['sections', 'sectionsLoading']),
        btnText(){
           return this.edit === true ? 'Edit' : 'Create';
        }
    },
    methods:{
        ...mapActions(['fetchSections', 'spliceSection']),
        createSection(e){
            let formData = new FormData(e.target);
            if (this.edit) {
                this.sectionLoading = true;
                formData.append('id', this.id)
                Axios.post('/edit-section', formData)
                .then(response => {
                    let data = JSON.parse(response.data);
                    if (data.error) {
                        Swal.fire(data.message)
                    }else{
                        this.$store.state.sections = data.sections
                    }
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.sectionLoading = false;
                    this.resetForm()
                })
            }else{
                this.sectionLoading = true;
                
                Axios.post('/new-section', formData)
                .then(response => {
                    let data = JSON.parse(response.data);
                    if (data.error) {
                        Swal.fire(data.message)
                    }else{
                        this.$store.state.sections = [...this.$store.state.sections, data.section]                        
                    }
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.sectionLoading = false;
                })
            }
        },
        editSection(section){
            this.edit = true
            this.id = section.id;
            this.section_name = section.section_name
            this.section_code = section.section_code
        },
        deleteSection(id, index, e){
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
                Axios.post('/delete-section', fd)
                .then(res => {
                    let data = JSON.parse(res.data);
                    if (data.error) {
                        Swal.fire('Error!', data.message, 'error')
                    }else{
                        this.spliceSection(index);
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
            this.id = ''
            this.section_name = ''
            this.section_code = ''
        },
        returnToPreviousPage(){
            window.history.length > 1
            ? this.$router.go(-1)
            : this.$router.push('/')
        }
        
    }
}
</script>

<style scoped>

.spinner{
    font-size: 30px;
}

i.spinner-sm{
    display: none !important;
}

</style>
