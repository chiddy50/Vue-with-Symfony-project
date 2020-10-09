import Axios from "axios";
export default {
  SET_CLASSES(state, payload) {
    state.classes = payload;
  },
  SET_SUBJECTS(state, payload) {    
    state.subjects = payload;
  },
  SET_SUBJECT_TYPES(state, payload) {
    state.subjectTypes = payload;
  },
  SET_SECTIONS(state, payload) {
    state.sections = payload;    
  },
  SET_PARENTS(state, payload) {
    state.parents = payload;
  },
  SET_GENDERS(state, payload) {
    state.genders = payload;
  },
  SET_EXAMS(state, payload) {
    state.exams = payload;
  },
  SET_MONTHS(state, payload) {
    state.months = payload;
  },
  SET_SESSIONS(state, payload) {
    state.sessions = payload;
  },
  SET_STUDENT_GROUPS(state, payload) {
    state.student_group = payload;
  },
  SET_STUDENTS(state, payload) {
    state.students = payload;
  },
  SET_TERMS(state, payload) {
    state.terms = payload;
  },
  SET_GRADES(state, payload) {
    state.grades = payload;
  },
  SPLICE_STUDENT: function(state, payload) {
    state.students.splice(payload, 1);
  },
  SPLICE_CLASS: function(state, payload) {
    state.classes.splice(payload, 1);
  },
  SPLICE_SUBJECT: function(state, payload) {
    state.subjects.splice(payload, 1);
  },
  SPLICE_SUBTYPE: function(state, payload) {
    state.subjectTypes.splice(payload, 1);
  },
  SPLICE_SECTION: function(state, payload) {
    state.sections.splice(payload, 1);
  },
  SPLICE_PARENT: function(state, payload) {
    state.parents.splice(payload, 1);
  },
  SPLICE_STUDENT_GRP: function(state, payload) {
    state.student_group.splice(payload, 1);
  },
  SPLICE_TERM: function(state, payload) {
    state.terms.splice(payload, 1);
  },
  SET_COUNTS(state, payload) {
    state.parentCount = payload.parentCount;
    state.studentCount = payload.studentCount;
    state.maleCount = payload.maleCount;
    state.femaleCount = payload.femaleCount;
  },

  SET_SEARCH_RESULT(state, payload) {
    state.students = payload.students;
    state.data.className = payload.className;
    state.data.sectionName = payload.sectionName;
  },

  SET_GROUP_SUBJECT(state, payload) {
    state.groupSubjects = payload;
  },
  MUTATE_CLASS_LOAD(state, payload){
    state.classLoading = payload;
  },
  MUTATE_SUBJECT_LOAD(state, payload){
    state.subjectLoading = payload;
  },
  MUTATE_SUBTYPE_LOAD(state, payload){
    state.subjectTypeLoading = payload;
  },
  MUTATE_SECTION_LOAD(state, payload){
    state.sectionLoading = payload;
  },
  MUTATE_PARENT_LOAD(state, payload){
    state.parentLoading = payload;
  },
  MUTATE_STUDENT_GRP_LOAD(state, payload){
    state.groupLoading = payload;
  },
  MUTATE_STUDENTS_LOAD(state, payload){
    state.studentsLoading = payload;
  },
  MUTATE_TERM_LOADING(state, payload){
    state.termsLoading = payload;
  },
  MUTATE_GRADES_LOAD(state, payload){
    state.gradesLoading = payload;
  },
  MUTATE_COUNT_LOAD(state, payload){
    state.countLoader = payload;
  },
  MUTATE_SUBJECT_GRP_LOAD(state, payload){
    state.groupSubjectLoad = payload;
  }

};
