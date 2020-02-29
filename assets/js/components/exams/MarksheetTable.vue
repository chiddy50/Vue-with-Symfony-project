<template>
    <div class="table-responsive result-table-box hide-table">
        <table class="table display data-table table-striped table-bordered text-nowrap">
            <thead>
                <tr class="text-center">
                    <th>Subject</th>
                    <th>Grade</th>
                    <th>Score</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>                            
                <tr class="text-center" v-for="(result, index) in results" :key="index">
                    <td>{{ result.subject }}</td>                                     
                    <td>{{ result.grade }}</td>                                     
                    <td>{{ result.score }}</td>                                     
                    <td :class="commentClass(result.grade)">{{ result.comment }}</td>                                     
                </tr>
            </tbody>
        </table>                            
    </div>
</template>

<script>
export default {
    name: 'MarksheetTable',
    props: {
        results: Array
    }
}
</script>

<style>

</style>