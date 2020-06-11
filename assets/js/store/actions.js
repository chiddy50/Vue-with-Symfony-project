import Axios from "axios";
export default {
  getParents: function({ commit }) {
    if (!this.state.parents.length) {
      commit("MUTATE_PARENT_LOAD", true);
      Axios.post("/parents")
      .then(response => {
        let data = JSON.parse(response.data);
        if (data.error) {
          Swal.fire({
            position: "top-end",
            icon: "error",
              title: data.message,
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            commit("SET_PARENTS", data.parents);
          }
        })
        .catch(err => {
          console.log(err);
        })
        .finally(() => {
          commit("MUTATE_PARENT_LOAD", false);
        });
    }
  },
  getClasses: function({ commit }) {
    if (!this.state.classes.length) {
      commit("MUTATE_CLASS_LOAD", true);
      Axios.post("/all-classes")
        .then(response => {
          let data = JSON.parse(response.data);
          if (data.error) {
            Swal.fire({
              position: "top-end",
              icon: "error",
              title: data.message,
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            commit("SET_CLASSES", data.classes);            
          }
        })
        .catch(err => {
          console.log(err);
        })
        .finally(() => {
          commit("MUTATE_CLASS_LOAD", false);
        });
    }
    
  },
  fetchSections: function({ commit }) {
    if (!this.state.sections.length) {
      commit('MUTATE_SECTION_LOAD', true);
      Axios.post("/all-section")
      .then(response => {
        let data = JSON.parse(response.data);
        if (data.error) {
          Swal.fire({
            position: "top-end",
              icon: "error",
              title: data.message,
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            commit("SET_SECTIONS", data.sections);
          }
        })
        .catch(err => {
          console.log(err);
        })
        .finally(() => {          
          commit('MUTATE_SECTION_LOAD', false);
        });
    }
  },
  fetchSubjects: function({ commit }) {
    // if(!this.state.subjects.length){
      commit("MUTATE_SUBJECT_LOAD", true);
      Axios.post("/all-subjects")
        .then(response => {
          let data = JSON.parse(response.data);
          if (data.error) {
            Swal.fire({
              position: "top-end",
              icon: "error",
              title: data.message,
              showConfirmButton: false,
              timer: 1500
            });
          } else {          
            commit("SET_SUBJECTS", data.subjects);
          }
        })
        .catch(err => {
          console.log(err);
        })
        .finally(() => {
          commit("MUTATE_SUBJECT_LOAD", false);
        });
  
      // }
  },
  fetchSubjectTypes: function({ commit }) {
    if (!this.state.subjectTypes.length) {
      commit('MUTATE_SUBTYPE_LOAD', true);
      Axios.post("/all-subject-type")
      .then(response => {
        let data = JSON.parse(response.data);
        if (data.error) {
            Swal.fire({
              position: "top-end",
              icon: "error",
              title: data.message,
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            commit("SET_SUBJECT_TYPES", data.types);
          }
        })
        .catch(err => {
          console.log(err);
        })
        .finally(() => {
          commit('MUTATE_SUBTYPE_LOAD', false);
        });
    }
  },
  getGroups: function({ commit }) {
    // if (!this.state.student_group.length) {
      commit('MUTATE_STUDENT_GRP_LOAD', true);
      Axios.post("/student-groups")
        .then(response => {          
          let data = JSON.parse(response.data);
          if (data.error) {
            Swal.fire({
              position: "top-end",
              icon: "error",
              title: data.message,
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            commit("SET_STUDENT_GROUPS", data.student_groups);
          }
        })
        .catch(error => console.error(error))
        .finally(() => (commit('MUTATE_STUDENT_GRP_LOAD', false)));
      // }
  },
  getStudents: function({ commit }) {
    // if (!this.state.students.length) {
      commit('MUTATE_STUDENTS_LOAD', true);
      Axios.post("/allstudents")
      .then(response => {
        let data = JSON.parse(response.data);
        if (data.error) {
          Swal.fire({
            position: "top-end",
            icon: "error",
            title: data.message,
            showConfirmButton: false,
            timer: 1500
            });
          } else {
            commit("SET_STUDENTS", data.students);
          }
        })
        .catch(err => {
          console.error(err);
        })
        .finally(() => commit('MUTATE_STUDENTS_LOAD', false) );
      // }
  },
  getGender: function({ commit }) {
    if (!this.state.genders.length) {
      Axios.post("/genders")
      .then(response => {
        let data = JSON.parse(response.data);
          if (data.error) {
            Swal.fire({
              position: "top-end",
              icon: "error",
              title: data.message,
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            commit("SET_GENDERS", data.genders);
          }
        })
        .catch(err => {
          console.error(err);
        });
    }
  },
  spliceStudent: function(context, payload) {
    context.commit("SPLICE_STUDENT", payload);
  },
  spliceClass: function(context, payload) {
    context.commit("SPLICE_CLASS", payload);
  },
  spliceSubject: function(context, payload) {
    context.commit("SPLICE_SUBJECT", payload);
  },
  spliceSubjectType: function(context, payload) {
    context.commit("SPLICE_SUBTYPE", payload);
  },
  spliceSection: function(context, payload) {
    context.commit("SPLICE_SECTION", payload);
  },
  spliceStudentGroup: function(context, payload) {
    context.commit("SPLICE_STUDENT_GRP", payload);
  },
  spliceParent: function(context, payload) {
    context.commit("SPLICE_PARENT", payload);
  },
  spliceTerm: function(context, payload) {
    context.commit("SPLICE_TERM", payload);
  },
  countAll: function({ commit }) {
    commit('MUTATE_COUNT_LOAD', true);
    Axios.all([
      Axios.post("/countparents"),
      Axios.post("/countstudents"),
      Axios.post("/gendercount")
    ])
    .then(res => {
      console.log(res);
        commit("SET_COUNTS", {
          parentCount: res[0].data.count,
          studentCount: res[1].data.count,
          maleCount: res[2].data.male_count,
          femaleCount: res[2].data.female_count,
        });
    })
    .catch(err => {
      console.error(err);
    })
    .finally(() => commit('MUTATE_COUNT_LOAD', false) );
  },
  getSingleStudent: function(context, payload) {
    context.commit("getSingleStudent", payload);
  },
  searchStudent: function(context, payload) {
    context.commit('MUTATE_STUDENTS_LOAD', true);
    let formData = new FormData(payload.target);
    Axios.post("/searchstudent", formData)
      .then(response => {
        let data = JSON.parse(response.data);
        console.log(data);
        
        if (data.error) {
          Swal.fire({
            position: "top-end",
            icon: "error",
            title: data.message,
            showConfirmButton: false,
            timer: 1500
          });
        } else {
          context.commit("SET_SEARCH_RESULT", {
            students: data.students,
            className: data.class_name,
            sectionName: data.section_name
          });          
        }
      })
      .catch(err => console.error(err))
      .finally(() => context.commit('MUTATE_STUDENTS_LOAD', false) );
  },
  fetchGroupSubject: function({ commit }) {
    commit('MUTATE_SUBJECT_GRP_LOAD', true);
    Axios.post("/allgroupsubjects")
    .then(res => {
      commit("SET_GROUP_SUBJECT", res.data.group_subject);
    })
    .catch(err => {
      console.error(err);
    })
    .finally(() => commit('MUTATE_SUBJECT_GRP_LOAD', false) );
  },
  getMonths: function({ commit }) {
    if (!this.state.months.length) {
      Axios.post("/months")
      .then(response => {
        let data = JSON.parse(response.data);
        if (data.error) {
          Swal.fire({
            position: "top-end",
            icon: "error",
            title: data.message,
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            commit("SET_MONTHS", data.months);
          }
        })
        .catch(err => {
          console.error(err);
        });
    }
  },
  getSessions: function({ commit }) {
    if (!this.state.sessions.length) {
      Axios.post("/sessions")
      .then(response => {
        let data = JSON.parse(response.data);
        if (data.error) {
          Swal.fire({
            position: "top-end",
            icon: "error",
              title: data.message,
              showConfirmButton: false,
              timer: 1500
            });
          } else {            
            commit("SET_SESSIONS", data.sessions);
          }
        })
        .catch(err => {
          console.error(err);
        });
    }
  },
  getTerms: function({ commit }) {
    // if (!state.terms.length) {
      commit('MUTATE_TERM_LOADING', true);
      Axios.post("/terms")
      .then(res => {
        let data = JSON.parse(res.data);
        if (data.error) {
          Swal.fire({
            position: "top-end",
            icon: "error",
            title: data.message,
            showConfirmButton: false,
            timer: 1500
          });
        } else {        
          commit("SET_TERMS", data.terms);
          }
        })
        .catch(err => {
          console.error(err);
        })
        .finally(() => commit('MUTATE_TERM_LOADING', false) );
      // }
  },
  getGrades: function({ commit }) {
    // if (!this.state.grades.length) {
      commit('MUTATE_GRADES_LOAD', true);
      Axios.post("/grades")
      .then(res => {;
        commit("SET_GRADES", res.data.grades);
      })
      .catch(err => {
        console.error(err);
      })
      .finally(() => commit('MUTATE_GRADES_LOAD', false))
    // }
  },
  getExams: function({ commit }) {
    // if (!this.state.exams.length) {
      Axios.post("/examinations")
      .then(res => {
        console.log(res);
        console.log(JSON.parse(res.data.exams));
        // commit("SET_EXAMS", res.data.exams);
      })
      .catch(err => {
        console.error(err);
      });
    // }
  }
};
