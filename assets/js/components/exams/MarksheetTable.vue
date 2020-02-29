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
    },
    methods: {
        commentClass(grade){	
			let answerClass = '';
			if (grade === 'A') {
				answerClass = 'excellent'
			}else if (grade === 'B') {
				answerClass = 'veryGood'
			}else if (grade === 'C') {
				answerClass = 'satisfactory'
			}else if (grade === 'D') {
				answerClass = 'fair'
			}else if (grade === 'F') {
				answerClass = 'failed'
			}
			return answerClass;
			
		}
    }
}
</script>

<style scoped>

.failed{
    color: #ff4444;
}
.veryGood{
    color: #2e42f1;
}
.satisfactory{
    color: #44f9ff;
}
.fair{
    color: pink;
}
.excellent{
    color: #35ec35;
}
</style>