<template>             
    <div class="row">
        <div class="col-sm-10 offset-1">
        <input type="text" class="form-control rounded-0 mb-3" id="searchstaff" placeholder="Search For staff">
        <table class="table table-dark table-striped text-center" id="staff_table">
            <thead>
                <tr>
                    <th>Staff No</th>
                    <th>Fullname</th>
                    <th>Gender</th>
                    <th>Designation</th>   
                    <th>View</th>
                    <th>Delete</th>                            
                </tr>
            </thead>
            <tbody id="staff-table-body"></tbody>
        </table>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AllStaff'
}
</script>
