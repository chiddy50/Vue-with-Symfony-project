<template>
    <div class="">

        <Header :title="'Parent'" :title2="'Edit Parent'"/>

        <div class="row">            

            <div class="col-sm-12">
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Edit {{ parent.fullname }}</h3>
                            </div>                            
                        </div>
                       
                        <form class="new-added-form" data-select2-id="18" @submit.prevent="editParent($event)">
                            <div class="row">
                                <input type="hidden" v-model="parent.id" name="id">
                                <div class="col-xl-6 col-lg-6 col-12 form-group">
                                    <label>Fullname *</label>
                                    <input type="text" v-model="parent.fullname" name="fullname" class="form-control rounded-0">
                                </div>
                                <div class="col-xl-6 col-lg-6 col-12 form-group">
                                    <label>E-Mail</label>
                                    <input type="email" name="email" v-model="parent.email" class="form-control rounded-0">
                                </div>
                                <div class="col-xl-6 col-lg-6 col-12 form-group">
                                    <label>Gender *</label>
                                    <select class="select2 form-control rounded-0" name="gender" v-model="parent.gender">
                                        <option value="">Please Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="others">Others</option>
                                    </select>                                
                                </div>
                                <div class="col-xl-6 col-lg-6 col-12 form-group">
                                    <label>Phone</label>
                                    <input type="text" v-model="parent.phone" name="phone" class="form-control rounded-0">
                                </div>
                                <div class="col-lg-6 col-12 form-group">
                                    <label for="address">Address</label>
                                    <textarea class="textarea form-control rounded-0" name="address" v-model="parent.address" id="form-message" cols="10" rows="9"></textarea>
                                </div>
                                
                                <div class="col-12 form-group mg-t-8">
                                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark rounded-0" :disabled="editLoad">
                                        Edit
                                    </button>                                    
                                    <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow rounded-0">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
import Axios from "axios";
import { mapGetters, mapActions, mapState } from 'vuex';
import Header from '../inc/Header.vue';

export default {
    name: 'EditParent',
    props: {
        parent: Object
    },
    components:{
        Header
    },
    
    data(){
        return{
            form:{
                id: '',
                fullname: '',
                email: '',
                gender: '',
                address: '',
                phone: ''
            },
            editLoad: false
        }
    },
    
    methods: {
        editParent(e){
            this.editLoad = true;
            let formData = new FormData(e.target);
            Axios.post('/edit-parent', formData)
            .then(response => {
                let data = JSON.parse(response.data)
                if (data.error === true) {
                    Swal.fire('Error!', data.message, 'error')
                }else{
                    this.$store.state.parents = data.parents
                    this.$router.push('allparents')    
                    this.resetForm()            
                }
            })
            .catch(err => {
                console.log(err);
            })
            .finally(() => {
                this.editLoad = false;                
            })
        },        
        resetForm(){
            this.parent.id = '';
            this.parent.fullname = '';
            this.parent.email = '';
            this.parent.gender = '';
            this.parent.address = '';
            this.parent.phone  = '';
        }
    }
}
</script>

<style>

</style>