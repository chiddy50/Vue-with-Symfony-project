<template>
    <div class="row">            
        <Header :title="'Terms'" :title2="'Add New Term'"/>

        <div class="col-sm-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Add New Term</h3>
                        </div>
                    </div>
                    
                    <form class="new-added-form" data-select2-id="18" @submit.prevent="addTerm($event)">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-12 form-group">
                                <label>Term Code *</label>
                                <input type="text" v-model="code" name="code" class="form-control rounded-0">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-12 form-group">
                                <label>Term Description</label>
                                <input type="text" v-model="description" name="description" class="form-control rounded-0">
                            </div>
                            
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" :disabled="termLoading" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark rounded-0">
                                    {{ btnText }}
                                </button>
                                
                                <button @click.prevent="resetForm" class="btn-fill-lg bg-blue-dark btn-hover-yellow rounded-0">Reset</button>
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
                            <h3>All Terms</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table table-striped table-bordered text-nowrap">
                            <thead>
                                <tr class="text-center">
                                    
                                    <th>Term Code</th>
                                    <th>Term Descripion</th>
                                    <th colspan="2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center" v-for="(term, index) in terms" :key="index">
                                    <td>{{ term.term_code }}</td>
                                    <td>{{ term.term_description }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-lg shadow-dark-peel bg-danger rounded-bottom text-light" @click="deleteTerm(term.id, index, $event)">
                                            <i class="fas fa-trash text-light"></i> 
                                        </button>
                                        <i class="fas fa-spinner fa-spin text-danger spinner-sm"></i>
                                    </td>
                                    <td>
                                        <button class="btn btn-lg shadow-dark-peel bg-success rounded-bottom text-light" @click="editTerm(term)">
                                            <i class="fas fa-cogs text-light"></i> 
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
</template>

<script>
import Swal from 'sweetalert2'
import Header from '../inc/Header.vue';
import Axios from 'axios'
import { mapActions, mapState } from 'vuex';

export default {
    name: 'Term',
    data(){
        return{
            termLoading: false,
            edit: false,
            id: '',
            code: '',
            description: ''
        }
    },
    components:{
        Header
    },
    created(){
        this.getTerms()
    },  
    computed: {
        ...mapState(['terms']),
        btnText(){
           return this.edit === true ? 'Edit' : 'Create';
        }
    },
    methods:{
        ...mapActions(['getTerms', 'spliceTerm']),

        addTerm(e){
            if (this.edit) {
                this.termLoading = true;
                let fd = new FormData(e.target)

                fd.append('id', this.id)
                Axios.post('/edit-term', fd)
                .then(response => {
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
                        this.$store.state.terms = data.terms
                    }
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.termLoading = false;
                    this.resetForm()
                })
            }else{
                this.termLoading = true
                let fd = new FormData(e.target)
                Axios.post('/new-term', fd)
                .then(response => {
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
                        this.$store.state.terms = [...this.$store.state.terms, data.term]                        
                    }
                })
                .catch(err => {
                    Swal.fire('Error!', 'There was an error', 'error')    
                    console.error(err);                
                })
                .finally(() => {
                    this.termLoading = false
                })  
            }
        },
        editTerm(term){
            this.edit = true
            this.id = term.id;
            this.code = term.term_code
            this.description = term.term_description
        },
        deleteTerm(id, index, e){
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
                Axios.post('/delete-term', fd)
                .then(res => {
                    console.log(res);
                    let data = JSON.parse(res.data);                    
                    if (data.error) {
                        Swal.fire('Error!', data.message, 'error')
                    }else{
                        this.spliceTerm(index);
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
            this.code = ''
            this.description = ''
        },
    }
}
</script>

<style scoped>
i.spinner-sm{
    display: none !important;
}
</style>