<template>

    <div class="col-lg-12">
        <div class="card dashboard-card-eleven">
            <div class="card-body">

                <div class="heading-layout1">
                    <div class="item-title">
                        <h3 class="text-uppercase">{{ className }}({{ sectionName }})</h3>
                    </div>
                    
                </div>

                <div class="table-box-wrap">
                    <form class="search-form-box">
                        <div class="row gutters-8">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                <input type="text" name="name" class="form-control" placeholder="Student Name...">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                <input type="text" name="roll_no" class="form-control" placeholder="Student Roll No...">
                            </div>
                        </div>
                    
                        <div class="table-responsive result-table-box">
                            <table class="table display data-table table-striped table-bordered text-nowrap">
                                <thead>
                                    <tr class="text-center">
                                        <th>Roll No</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>                            
                                    <tr class="text-center" v-for="student in students" :key="student.id">
                                        <td>{{ student.roll_no }}</td>
                                        <td>{{ student.firstname }} {{ student.lastname }}</td>
                                        <td>
                                            <router-link  :to="{ name: 'SingleMarksheet', params: { student } }" class="btn-own">View MarkSheet</router-link>
                                        </td>                                      
                                    </tr>
                                </tbody>
                            </table>
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        students: Array,
        sectionName: String,
        className: String
    }
}
</script>

<style scoped>
.btn-own{
    padding: 6px;
    background: #ff4532;
    border: none;
    outline: none;
    color: #fff;
    font-size: 13px;
    cursor: pointer;
}
</style>