<template>
  <div class="row mt-5">
    <Header :title="'Classes'" :title2="'Add New Class'" />

    <div class="col-md-12">
      <div class="card height-auto">
        <div class="card-body">
          <div class="heading-layout1">
            <div class="item-title">
              <h3>Create A Class</h3>
            </div>
          </div>

          <form class="new-added-form" @submit.prevent="createClass($event)">
            <div class="row">
              <div class="col-12-xxxl col-lg-6 col-12 form-group">
                <label>Class Name</label>
                <input
                  type="text"
                  v-model="class_name"
                  name="class_name"
                  placeholder
                  class="form-control rounded-0"
                />
              </div>
              <div class="col-12-xxxl col-lg-6 col-12 form-group">
                <label>Class Code</label>
                <input
                  type="text"
                  v-model="class_code"
                  name="class_code"
                  placeholder
                  class="form-control rounded-0"
                />
              </div>

              <div class="col-12 form-group mg-t-8">
                <button
                  type="submit"
                  class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark"
                  :disabled="classLoad"
                >{{btnText}}</button>
                <button
                  @click.prevent="resetForm"
                  class="btn-fill-lg bg-blue-dark btn-hover-yellow"
                >Reset</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card height-auto">
        <div class="card-body">
          <div class="heading-layout1">
            <div class="item-title">
              <h3>All Classes</h3>
            </div>
            <div class>
              <a href="#" @click="getClasses()">
                <i class="fas fa-redo-alt text-orange-peel"></i> Load
              </a>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table display data-table table-striped table-bordered text-nowrap">
              <thead>
                <tr class="text-center">
                  <th>Class Name</th>
                  <th>Delete</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody v-if="!classLoading">
                <tr v-for="(single_class, index) in classes" :key="single_class.id">
                  <td class="text-uppercase">{{ single_class.class_name }}</td>
                  <td class="text-center">
                    <button
                      class="btn btn-lg shadow-dark-peel bg-danger rounded-bottom text-light"
                      @click="deleteClass(single_class.id, index, $event)"
                    >
                      <i class="fas fa-trash text-light"></i>
                    </button>
                    <i class="fas fa-spinner fa-spin text-danger spinner-sm"></i>
                  </td>
                  <td>
                    <button
                      class="btn btn-lg shadow-dark-peel bg-success rounded-bottom text-light"
                      @click="editClass(single_class)"
                    >
                      <i class="fas fa-cogs text-light"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
              <tr v-else>
                <td>
                  <i class="fas fa-spinner fa-spin text-dark" id="spinner-md"></i>
                </td>
                <td>
                  <i class="fas fa-spinner fa-spin text-dark" id="spinner-md"></i>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4" id="class_student">
      <div class="card height-auto">
        <div class="card-body">
          <div class="heading-layout1">
            <div class="item-title">
              <h3>{{ returned_class_name | toUpper }} STUDENTS</h3>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table display data-table table-striped table-bordered text-nowrap">
              <thead>
                <tr>
                  <th class="text-center">Fullname</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="student in class_students" :key="student.id">
                  <td class="text-center">{{ student.firstname }} {{ student.lastname }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4" v-if="getStudentLoading">
      <i class="fas fa-spinner fa-spin text-danger text-center" id="spinner-lg"></i>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
import { mapActions, mapState } from "vuex";
import Header from "../inc/Header.vue";

export default {
  name: "Classes",
  components: {
    Header
  },
  data() {
    return {
      id: "",
      class_name: "",
      class_code: "",
      classLoad: false,
      getStudentLoading: false,
      deleteLoad: false,
      edit: false,
      class_students: [],
      returned_class_name: ""
    };
  },
  mounted() {
    this.getClasses();
  },
  computed: {
    ...mapState(["classes", "classLoading"]),
    btnText() {
      return this.edit === true ? "Edit" : "Create";
    }
  },
  methods: {
    ...mapActions(["appendClass", "getClasses", "spliceClass"]),
    createClass(e) {
      if (this.edit) {
        this.classLoad = true;
        let formData = new FormData(e.target);
        formData.append("id", this.id);
        Axios.post("/edit-class", formData)
          .then(response => {
            let data = JSON.parse(response.data);
            if (data.error === true) {
              Swal.fire("Error!", data.message, "error");
            } else {
              this.$store.state.classes = data.classes;
            }
          })
          .catch(err => {
            console.log(err);
          })
          .finally(() => {
            this.classLoad = false;
            this.resetForm();
          });
      } else {
        this.classLoad = true;
        let formData = new FormData(e.target);

        Axios.post("/newclass", formData)
          .then(response => {
            let data = JSON.parse(response.data);
            if (data.error === true) {
              Swal.fire("Error!", data.message, "error");
            } else {
              this.$store.state.classes.push(data.created_class);
            }
          })
          .catch(err => {
            console.log(err);
          })
          .finally(() => {
            this.classLoad = false;
          });
      }
    },
    editClass(single_class) {
      this.edit = true;
      this.id = single_class.id;
      this.class_name = single_class.class_name;
      this.class_code = single_class.class_code;
    },

    getStudent(id) {
      $("#class_student").slideUp(10);
      this.getStudentLoading = true;
      let formData = new FormData();

      formData.append("id", id);
      Axios.post("/return-students-by-class", formData)
        .then(res => {
          this.getStudentLoading = false;
          Swal.fire("Success", "Here are the Students Boss!!", "success");
          $("#class_student").slideDown(500);
          let data = res.data;
          this.class_students = data.students;
          this.returned_class_name = data.class_name;
          console.log(data);
        })
        .catch(err => {
          this.getStudentLoading = false;
          console.error(err);
        });
    },
    deleteClass(id, index, e) {
      if (confirm("Are you sure?")) {
        var target, spinner;
        if (e.target.classList.contains("bg-danger")) {
          target = e.target;
          target.hidden = true;
          spinner = e.target.nextElementSibling;
          spinner.classList.remove("spinner-sm");
          //Check if icon tag inside button was clicked
        } else if (e.target.classList.contains("fa-trash")) {
          target = e.target.parentElement;
          target.hidden = true;
          spinner = e.target.parentElement.nextElementSibling;
          spinner.classList.remove("spinner-sm");
        }

        let fd = new FormData();
        fd.append("id", id);
        Axios.post("/delete-class", fd)
          .then(res => {
            let data = JSON.parse(res.data);
            if (data.error) {
              Swal.fire("Error!", data.message, "error");
            } else {
              this.spliceClass(index);
            }
          })
          .catch(err => {
            console.error(err);
          })
          .finally(() => {
            target.hidden = false;
            spinner.classList.add("spinner-md");
          });
      }
    },
    resetForm() {
      this.edit = false;
      this.id = "";
      this.class_name = "";
      this.class_code = "";
    },
    returnToPreviousPage() {
      window.history.length > 1 ? this.$router.go(-1) : this.$router.push("/");
    },
    goBack() {
      this.returnToPreviousPage();
    }
  },
  filters: {
    toUpper(val) {
      return val.toUpperCase();
    }
  }
};
</script>

<style scoped>
#class_student {
  display: none;
}

.buttons {
  cursor: pointer !important;
}
i.spinner-sm {
  display: none !important;
}
</style>
