<template>
  <div class="row">
    <Header :title="'Attendance'" :title2="'Subject Attendance'" />

    <div class="col-sm-12">
      <div class="card height-auto">
        <div class="card-body">
          <div class="heading-layout1">
            <div class="item-title">
              <h3>Choose Class & Section</h3>
            </div>
          </div>
          <i
            v-if="classLoading || sectionLoading || $store.state.searchLoading"
            class="fas fa-spinner fa-spin text-primary spinner"
          ></i>

          <form class="new-added-form" @submit.prevent="searchStudent($event)">
            <div class="row">
              <div class="col-xl-4 col-lg-4 col-12 form-group">
                <label>Select Class</label>
                <select
                  v-if="!classLoading" name="class_id" 
                  class="form-control select2" v-model="form.class_id"
                  >
                  <option value>Select Class</option>
                  <option
                    :key="one_class.id"
                    v-for="one_class in classes"
                    :value="one_class.id"
                  >{{ one_class.class_name }}</option>
                </select>
              </div>
              <div class="col-xl-4 col-lg-4 col-12 form-group">
                <label>Select Section</label>
                <select
                  v-if="!sectionLoading"
                  name="section_id"
                  class="form-control select2"
                  v-model="form.section_id"
                >
                  <option value>Select Section</option>
                  <option
                    :key="section.id"
                    v-for="section in sections"
                    :value="section.id"
                  >{{ section.section_name }}</option>
                </select>
              </div>
              <div class="col-xl-4 col-lg-4 col-12 form-group">
                <label>Select Student Group</label>
                <select
                  v-if="!groupLoading"
                  name="student_group"
                  class="form-control select2"
                  v-model="form.student_group"
                >
                  <option value>Please Select Group</option>
                  <option
                    v-for="group in student_group"
                    :key="group.id"
                    :value="group.id"
                  >{{ group.group_name }}</option>
                </select>
              </div>

              <div class="col-12 form-group mg-t-8">
                <button
                  type="submit"
                  :disabled="$store.state.searchLoading"
                  class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark rounded-0"
                >Retrieve</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <SubjectAttendanceTable
      v-if="$store.state.filteredStudents.length && subjects.length"
      :subjects="subjects"
    />
  </div>
</template>

<script>
import Axios from "axios";
import Header from "../inc/Header.vue";
import { mapState, mapActions } from "vuex";
import SubjectAttendanceTable from "./components/SubjectAttendanceTable.vue";

export default {
  name: "SubjectAttendance",
  components: {
    Header,
    SubjectAttendanceTable
  },
  data() {
    return {
      form: {
        class_id: "",
        section_id: "",
        student_group: "",
        class_name: "",
        section_name: ""
      },
      subjects: []
    };
  },
  mounted() {
    this.fetchSections(), this.getClasses(), this.getGroups();
  },
  computed: {
    ...mapState([
      "classes",
      "sections",
      "classLoading",
      "sectionLoading",
      "student_group",
      "groupLoading"
    ])
  },
  methods: {
    ...mapActions(["getClasses", "fetchSections", "getGroups"]),

    searchStudent(e) {
      console.log(e.target);

      this.$store.state.searchLoading = true;
      let formData = new FormData(e.target);

      Axios.post("/searchstudent", formData)
        .then(response => {
          this.$store.state.searchLoading = false;

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
            this.$store.state.filteredStudents = data.students;
            this.subjects = data.subjects;
          }
          // let data = response.data;
          // this.class_name = data.class_name;
          // this.section_name = data.section_name;
        })
        .catch(err => console.error(err))
        .finally(() => (this.$store.state.searchLoading = false));
    }
  }
};
</script>

<style scoped>
.spinner {
  font-size: 50px;
}
</style>