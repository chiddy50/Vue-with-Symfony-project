export default {
    getParents: function(context){
        context.commit('getParents');
    },
    getClasses: function(context){
        context.commit('getClasses');
    },
    fetchSections: function(context){
        context.commit('fetchSections');
    },
    fetchSubjects: function(context){
        context.commit('fetchSubjects');
    },
    fetchSubjectTypes: function(context){
        context.commit('fetchSubjectTypes');
    },
    getAll: function(context){
        context.commit('getAll');
    },
    getGroups: function(context){
        context.commit('getGroups');
    },
    getStudents: function(context){
        context.commit('getStudents');
    },
    getGender: function(context){
        context.commit('getGender');
    },
    spliceStudent: function(context, payload){
        context.commit('spliceStudent', payload);
    },
    spliceClass: function(context, payload){
        context.commit('spliceClass', payload);
    },
    spliceSubject: function(context, payload){
        context.commit('spliceSubject', payload);
    },
    spliceSubjectType: function(context, payload){
        context.commit('spliceSubjectType', payload);
    },
    spliceSection: function(context, payload){
        context.commit('spliceSection', payload);
    },
    spliceStudentGroup: function(context, payload){
        context.commit('spliceStudentGroup', payload);
    },
    spliceParent: function(context, payload){
        context.commit('spliceParent', payload);
    },
    spliceTerm: function(context, payload){
        context.commit('spliceTerm', payload);
    },  
    countAll: function(context){
        context.commit('countAll');
    },
    getSingleStudent: function(context, payload){
        context.commit('getSingleStudent', payload);
    },
    searchStudent: function(context){
        context.commit('searchStudent');
    },
    fetchGroupSubject: function(context){
        context.commit('fetchGroupSubject');
    },
    getMonths: function(context){
        context.commit('getMonths');
    },
    getSessions: function(context){
        context.commit('getSessions');
    },
    getTerms: function(context){
        context.commit('getTerms');
    },
    getGrades: function(context){
        context.commit('getGrades');
    },
    getExams: function(context){
        context.commit('getExams');
    },
    
    

   
};

