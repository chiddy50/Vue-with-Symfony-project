<template>
    <div class="col-lg-12">
        <div class="card dashboard-card-eleven">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>{{ firstname }} {{ lastname }}'s Subjects</h3>
                    </div>
                    
                </div>
                <div class="table-box-wrap">
                    <form class="search-form-box">
                        <div class="row gutters-8">
                            <div class="col-lg-4 col-12 form-group">
                                <input type="text" placeholder="Search by Exam ..."
                                    class="form-control">
                            </div>
                            <div class="col-lg-3 col-12 form-group">
                                <input type="text" placeholder="Search by Subject ..."
                                    class="form-control">
                            </div>
                            <div class="col-lg-3 col-12 form-group">
                                <input type="text" placeholder="dd/mm/yyyy"
                                    class="form-control">
                            </div>
                            <div class="col-lg-2 col-12 form-group">
                                <button type="submit"
                                    class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive result-table-box">
                        <table class="table display data-table text-nowrap">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input type="checkbox"
                                                class="form-check-input checkAll">
                                            <label class="form-check-label">ID</label>
                                        </div>
                                    </th>
                                    <th>Exam Name</th>
                                    <th>Subject</th>
                                    <th>Grade</th>
                                    <th>Percent</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>                            
                                <tr v-for="(subject, index) in studentSubject" :key="index">
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input">
                                            <label class="form-check-label">#0025</label>
                                        </div>
                                    </td>
                                    <td>First Semister</td>
                                    <td>{{ subject.subject }}</td>
                                    <td>A</td>
                                    <td>99.00 > 100</td>
                                    <td>22/02/2019</td>
                                    
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
export default {
    name: 'studentSubject',
    props:{
        studentSubject: Array,
        firstname: String,
        lastname: String
    }
}
</script>

<style>

</style>