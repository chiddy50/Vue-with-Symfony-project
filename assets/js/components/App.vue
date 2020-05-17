<template>
   	<div>
        <!-- Preloader Start Here -->
        <div id="preloader"></div>
        <!-- Preloader End Here -->
        <div id="wrapper" class="wrapper bg-ash">
            <Navbar/>    
            <div class="dashboard-page-one">
                <Sidebar/>
                <div class="dashboard-content-one">
                    
                    <!-- <keep-alive> -->
                    <router-view></router-view>
                    <!-- </keep-alive> -->

                    <!-- <div class="col-md-12"> -->
                    <footer class="footer-wrap-layout1">
                        <div class="copyright">
                            © Copyrights Codewell {{ year }}. All rights reserved. Designed by 
                            Chiddy
                        </div>
                    </footer>
                    <!-- </div> -->
                </div>
            </div>
        </div>
	</div>
</template>

<script>
import Navbar from './inc/Navbar.vue';
import Sidebar from './inc/Sidebar.vue';
import { mapActions } from 'vuex';
export default {
	name:'app',
	components: {
		Navbar,
		Sidebar
	},
	data(){
		return{
            year: new Date().getFullYear()
		}
    },
    mounted(){
        this.getClasses(),
        this.fetchSections()
    },
	methods:{
        ...mapActions(['getClasses', 'fetchSections']),
	}
}
</script>

<style>

</style>
