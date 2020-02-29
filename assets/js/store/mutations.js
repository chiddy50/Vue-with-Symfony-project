import Axios from 'axios';
export default {
    getClasses(state){
        // if(!state.classes.length){
            state.classLoading = true;
            Axios.post('/all-classes')
            .then(response => {
                let classes = JSON.parse(response.data);
                if (classes.error) {
                    Swal.fire(classes.message)
                }else{
                    state.classes = classes.classes;
                }
            })
            .catch(err => {
                console.log(err);
            })
            .finally(() => {
                state.classLoading = false;
            });
        // }
    },
        
    fetchSubjects(state){
        // if(!state.subjects.length){
            state.subjectLoading = true;
            Axios.post('/all-subjects')
            .then(response => {
                let data = JSON.parse(response.data)
                if (data.error) {
                    Swal.fire('Error!', data.message, 'error')
                }else{
                    state.subjects = data.subjects;   
                }    
            
            })
            .catch(err => {
                console.log(err);
            })
            .finally(() => {
                state.subjectLoading = false;
            });
                
        // }
    },
    fetchSubjectTypes(state){
        if (!state.subjectTypes.length) {
            state.subjectTypeLoading = true;
            Axios.post('/all-subject-type')
            .then(response => {                
                let data = JSON.parse(response.data)
                if (data.error) {
                    Swal.fire('Error!', data.message, 'error')                    
                }else{
                    state.subjectTypes = data.types;   
                }
            })
            .catch(err => {
                console.log(err);
            })
            .finally(() => {
                state.subjectTypeLoading = false;
            });            
        }
    },
    fetchSections(state){
        // if(!state.sections.length){
            state.sectionLoading = true;
            Axios.post('/all-section')
            .then(response => {
                let data = JSON.parse(response.data)
                if (data.error) {
                    Swal.fire('Error!', data.message, 'error')                    
                }else{
                    state.sections = data.sections;
                }
            })
            .catch(err => {
                console.log(err);
            })
            .finally(() => {
                state.sectionLoading = false;
            });            
        // }
    },
    getParents(state){
        if(!state.parents.length){
            state.parentLoading = true;
            Axios.post('/parents')
            .then(response => {
                let data = JSON.parse(response.data)
                if (data.error) {
                    Swal.fire('Error!', data.message, 'error')                    
                }else{
                    state.parents = data.parents;
                }
            })
            .catch(err => {
                console.log(err);
            })
            .finally(() => {
                state.parentLoading = false;
            }); 
        }
    },
    getGender(state){
        if (!state.genders.length) {
            Axios.post('/genders')
            .then(response => {                
                let data = JSON.parse(response.data)
                if (data.error) {
                    Swal.fire('Error!', data.message, 'error')                    
                }else{
                    state.genders = data.genders;
                }
                
            })
            .catch(err => {
                console.error(err);
            });            
        }        
    },
    getExams(state){
        if (!state.exams.length) {
            Axios.post('/examinations')
            .then(res => {         
                console.log(res);
                console.log(JSON.parse(res.data.exams));                
                // state.exams = res.data.exams;                
            })
            .catch(err => {
                console.error(err);
            });            
        }        
    },
    getMonths(state){
        if (!state.months.length) {
            Axios.post('/months')
            .then(response => {
                let data = JSON.parse(response.data)
                console.log(data);
                
                if (data.error) {
                    Swal.fire('Error!', data.message, 'error')                    
                }else{
                    state.months = data.months;
                }
            })
            .catch(err => {
                console.error(err);            
            });            
        }
    },
    getSessions(state){
        if (!state.sessions.length) {
            Axios.post('/sessions')
            .then(response => {
                let data = JSON.parse(response.data)
                if (data.error) {
                    Swal.fire('Error!', data.message, 'error')                    
                }else{
                    state.sessions = data.sessions;
                }
            })
            .catch(err => {
                console.error(err);            
            });
        }
    },
    getAll(state){
        state.classLoading = true;
        Axios.all([
            Axios.post('/parents'),
            Axios.post('/getgroup'),
            Axios.post('/months'),
            Axios.post('/sessions')
        ])
        .then(res => {
            state.classLoading = false;
            console.log(res);
            state.parents = res[0].data.parents;
            state.student_group = res[1].data.student_groups;
            state.months = res[2].data.months;
            state.sessions = res[3].data.sessions;                    
        })
        .catch(err => {
            state.classLoading = false;
            console.error(err);
        });
    },
    getGroups(state){
        // if (!state.student_group.length) {
            Axios.post('/student-groups')
            .then(response => {
                let data = JSON.parse(response.data)
                if (data.error) {
                    Swal.fire('Error!', data.message, 'error')                    
                }else{
                    state.student_group = data.student_groups;
                }
            })
            .catch(error => {
                console.error(error);
            });            
        // }
    },
    getStudents(state){
        // if (!state.students.length) {
            state.studentsLoading = true;
            Axios.post('/allstudents')
            .then(response => {
                let data = JSON.parse(response.data)
                if (data.error) {
                    Swal.fire('Error!', data.message, 'error')                    
                }else{
                    state.students = data.students;
                }
            })
            .catch(err => {
                console.error(err);
            })
            .finally(() => {
                state.studentsLoading = false;
            });            
        // }
    },
    getTerms(state){
        // if (!state.terms.length) {
            state.termsLoading = true;
            Axios.post('/terms')
            .then(res => {
                let data = JSON.parse(res.data);
                if(data.error){
                    Swal.fire('Error!', data.message, 'error');
                }else{
                    state.terms = data.terms;
                }                
            })
            .catch(err => {
                console.error(err);
            })
            .finally(() => {
                state.termsLoading = false;
            });   
        // }
    },
    getGrades(state){
        // if (!state.grades.length) {
            state.gradesLoading = true;
            Axios.post('/grades')
            .then(res => {
                state.gradesLoading = false;
                state.grades = res.data.grades;
            })
            .catch(err => {
                state.gradesLoading = false;
                console.error(err);
            });            
        // }
    },
    spliceStudent: function(state, payload){
        state.students.splice(payload, 1);
    },
    spliceClass: function(state, payload){
        state.classes.splice(payload, 1);
    },
    spliceSubject: function(state, payload){
        state.subjects.splice(payload, 1);
    }, 
    spliceSubjectType: function(state, payload){
        state.subjectTypes.splice(payload, 1);
    },
    spliceSection: function(state, payload){
        state.sections.splice(payload, 1);
    }, 
    spliceParent: function(state, payload){
        state.parents.splice(payload, 1);
    },  
    spliceStudentGroup: function(state, payload){
        state.student_group.splice(payload, 1);
    },
    spliceTerm: function(state, payload){
        state.terms.splice(payload, 1);
    },    
    countAll(state){
        this.countLoader = true;
        Axios.all([
            Axios.post('/countparents'),                
            Axios.post('/countstudents'),
            Axios.post('/gendercount')
            
        ])
        .then(res => {                
            console.log(res);
            state.parentCount = res[0].data.count;
            state.studentCount = res[1].data.count;
            state.maleCount = res[2].data.male_count;
            state.femaleCount = res[2].data.female_count;
            this.countLoader = false;
        })
        .catch(err => {
            this.countLoader = false;
            console.error(err);
        });
    },
 
    searchStudent(state)
    {
        let formData = new FormData();
        formData.append('class_id', state.search.class_id);
        formData.append('section_id', state.search.section_id);
        Axios.post('/searchstudent', formData)
        .then(response => {   
            let data = JSON.parse(response.data)
            if (data.error) {
                Swal.fire('Error!', data.message, 'error')                    
            }else{
                state.students = data.students;
            }
                    
        })
        .catch(err => {
            console.error(err);            
        });
    },

    fetchGroupSubject(state)
    {
        state.groupSubjectLoad = true;
        Axios.post('/allgroupsubjects')
        .then(res => {   
            state.groupSubjects =  res.data.group_subject;        
        })
        .catch(err => {
            console.error(err);
        })
        .finally(() => {
            state.groupSubjectLoad = false;
        });
    },
    

};

