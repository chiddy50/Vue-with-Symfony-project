<template>
    <div class="col-4-xxxl col-12">
        <div class="card dashboard-card-ten">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>About Me</h3>
                    </div>                    
                </div>
                <div class="student-info">
                    <div class="media media-none--xs">
                        <div class="item-img">
                            <img src="../../../../../public/img/figure/student.png" class="media-img-auto" alt="student">
                        </div>
                        <div class="media-body">
                            <h3 class="item-title">
                                <!-- <i class="fas fa-spinner fa-spin text-center text-info"></i> -->
                                {{ singleStudent.firstname }} {{ singleStudent.lastname }}
                            </h3>
                            <!-- <p></p> -->
                        </div>
                    </div>
                    
                    <div class="table-responsive info-table">
                        <table class="table text-nowrap">
                            <tbody>
                                <tr>
                                    <td>Firstname:</td>
                                    <td class="font-medium text-dark-medium">
                                        <span>{{ singleStudent.firstname }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lastname:</td>
                                    <td class="font-medium text-dark-medium">
                                        <span>{{ singleStudent.lastname }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Roll:</td>
                                    <td class="font-medium text-dark-medium">
                                        <span>{{ singleStudent.roll_no }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gender:</td>
                                    <td class="font-medium text-dark-medium">
                                        <span>{{ singleStudent.gender.gender }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Class:</td>
                                    <td class="font-medium text-dark-medium">
                                        <span>{{ singleStudent.classes.class_name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Section:</td>
                                    <td class="font-medium text-dark-medium">
                                        <span>{{ singleStudent.section.section_name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Group:</td>
                                    <td class="font-medium text-dark-medium">
                                        <span>{{ singleStudent.student_group.group_name }}</span>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>Parent:</td>
                                    <td class="font-medium text-dark-medium">
                                        <span>{{ singleStudent.parent.fullname }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>E-mail:</td>
                                    <td class="font-medium text-dark-medium">
                                        <span>{{ singleStudent.email }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date Of Birth:</td>
                                    <td class="font-medium text-dark-medium">
                                        <i v-if="dateLoading" class="fas fa-spinner fa-spin text-center text-info"></i> <span>{{ dob }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Admission Date:</td>
                                    <td class="font-medium text-dark-medium">
                                        <i v-if="dateLoading" class="fas fa-spinner fa-spin text-center text-info"></i> <span>{{ doa }}</span>
                                    </td>
                                </tr>   
                                <div>
                                    <button @click="returnToPreviousPage" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark rounded-0">Back</button>
                                </div>                                 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ProfileBox',
    props:{
        singleStudent: Object,
        doa: String,
        dob: String,
        dateLoading: Boolean
    },
    methods:{
        returnToPreviousPage(){
            window.history.length > 1
            ? this.$router.go(-1)
            : this.$router.push('/')
        },
    }
}
</script>

<style>

</style>