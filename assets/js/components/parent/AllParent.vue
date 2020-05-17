<template>
  <div class>
    <Header :title="'Parents'" :title2="'Add New Parent'" />

    <div class="row">
      <div class="col-sm-12">
        <div class="card height-auto">
          <div class="card-body">
            <div class="heading-layout1">
              <div class="item-title">
                <h3>All Parents</h3>
              </div>
            </div>
            <form class="mg-b-20">
              <div class="row gutters-8">
                <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                  <input type="text" placeholder="Search by ID ..." class="form-control" />
                </div>
                <div class="col-4-xxxl col-xl-4 col-lg-3 col-12 form-group">
                  <input type="text" placeholder="Search by Name ..." class="form-control" />
                </div>
                <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                  <input type="text" placeholder="Search by Phone ..." class="form-control" />
                </div>
                <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                  <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                </div>
              </div>
            </form>

            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item">
                  <button type="button" class="page-link" v-if="page != 1" @click="page--">Previous</button>
                </li>
                <li class="page-item">
                  <button
                    type="button"
                    class="page-link"
                    v-for="(pageNumber, index) in pages.slice(page-1, page+5)"
                    :key="index"
                    @click="page = pageNumber"
                  >{{pageNumber}}</button>
                </li>
                <li class="page-item">
                  <button
                    type="button"
                    @click="page++"
                    v-if="page < pages.length"
                    class="page-link"
                  >Next</button>
                </li>
              </ul>
            </nav>

            <div class="table-responsive">
              <table class="table display data-table text-nowrap">
                <thead>
                  <tr class="text-center">
                    <th>Fullname</th>
                    <th>Gender</th>
                    <th colspan="4"></th>
                  </tr>
                </thead>
                <tbody id="student-table-body" v-if="!parentLoading">
                  <tr
                    class="text-center"
                    v-for="(parent, index) in displayedParents"
                    :key="parent.id"
                  >
                    <td>{{ parent.fullname }}</td>
                    <td class="text-capitalize">{{ parent.gender }}</td>
                    <td>
                      <button
                        @click="sendViewId(parent.id)"
                        data-toggle="modal"
                        data-target="#parent_view_modal"
                        class="btn btn-lg shadow-dark-peel bg-warning rounded-bottom text-light"
                      >
                        <i class="fas fa-eye text-light"></i>
                      </button>
                    </td>
                    <td class="text-center">
                      <button
                        class="btn btn-lg shadow-dark-peel bg-danger rounded-bottom text-light"
                        @click="deleteParent(parent.id, index, $event)"
                      >
                        <i class="fas fa-trash text-light"></i>
                      </button>
                      <i class="fas fa-spinner fa-spin text-danger spinner-sm"></i>
                    </td>
                    <td>
                      <router-link
                        :to="{ name: 'EditParent', params: { parent } }"
                        class="btn btn-lg shadow-dark-peel bg-success rounded-bottom text-light"
                      >
                        <i class="fas fa-pencil-alt text-light"></i>
                      </router-link>
                    </td>
                  </tr>
                </tbody>
                <tr v-else>
                  <td>
                    <i class="fas fa-spinner fa-spin text-success" id="spinner-md"></i>
                  </td>
                  <td>
                    <i class="fas fa-spinner fa-spin text-success" id="spinner-md"></i>
                  </td>
                  <td>
                    <i class="fas fa-spinner fa-spin text-success" id="spinner-md"></i>
                  </td>
                  <td>
                    <i class="fas fa-spinner fa-spin text-success" id="spinner-md"></i>
                  </td>
                  <td>
                    <i class="fas fa-spinner fa-spin text-success" id="spinner-md"></i>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- The View Modal -->
    <div class="modal fade" id="parent_view_modal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-0">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Parent Info</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="card dashboard-card-ten">
              <div class="card-body">
                <div class="heading-layout1">
                  <div class="item-title">
                    <h3>About Me</h3>
                  </div>
                </div>
                <div class="student-info">
                  <div class="media media-none--xs">
                    <div class="item-img">
                      <img src="img/figure/student.png" class="media-img-auto" alt="student" />
                    </div>
                    <div class="media-body">
                      <i
                        class="fas fa-spinner fa-spin text-center text-info"
                        id="spinner-md"
                        v-if="viewLoading"
                      ></i>
                      <h3 v-else class="item-title info-title">{{ fullname }}</h3>
                      <p></p>
                    </div>
                  </div>
                  <div class="table-responsive info-table">
                    <table class="table text-nowrap">
                      <tbody>
                        <tr>
                          <td>Fullname:</td>
                          <td class="font-medium text-dark-medium">
                            <i
                              class="fas fa-spinner fa-spin text-center text-info"
                              v-if="viewLoading"
                            ></i>
                            <span>{{ fullname }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>Gender:</td>
                          <td class="font-medium text-dark-medium">
                            <i
                              class="fas fa-spinner fa-spin text-center text-info"
                              v-if="viewLoading"
                            ></i>
                            <span>{{ gender }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>E-Mail:</td>
                          <td class="font-medium text-dark-medium">
                            <i
                              class="fas fa-spinner fa-spin text-center text-info"
                              v-if="viewLoading"
                            ></i>
                            <span>{{ email }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>Phone:</td>
                          <td class="font-medium text-dark-medium">
                            <i
                              class="fas fa-spinner fa-spin text-center text-info"
                              v-if="viewLoading"
                            ></i>
                            <span>{{ phone }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>Address:</td>
                          <td class="font-medium text-dark-medium">
                            <i
                              class="fas fa-spinner fa-spin text-center text-info"
                              v-if="viewLoading"
                            ></i>
                            <span>{{ address }}</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <button
                    type="submit"
                    class="fw-btn-fill btn-gradient-yellow"
                    data-dismiss="modal"
                  >Close</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End -->
  </div>
</template>

<script>
import Axios from "axios";
import { mapGetters, mapActions, mapState } from "vuex";
import Header from "../inc/Header.vue";

export default {
  name: "AllParent",
  components: {
    Header
  },
  data() {
    return {
      viewLoading: false,
      singleParent: "",
      fullname: "",
      email: "",
      gender: "",
      phone: "",
      address: "",
      page: 1,
      perPage: 3,
      pages: []
    };
  },
  mounted() {
    this.getParents();
  },
  computed: {
    ...mapState(["parents", "parentLoading"]),

    displayedParents() {
      return this.paginate(this.parents);
    }
  },
  methods: {
    ...mapActions(["getParents", "spliceParent"]),

    sendViewId(id) {
      this.viewLoading = true;
      let formData = new FormData();
      formData.append("id", id);
      Axios.post("/parentview", formData)
        .then(res => {
          this.viewLoading = false;
          var parent = JSON.parse(res.data);
          this.fullname = parent.parent.fullname;
          this.email = parent.parent.email;
          this.gender = parent.parent.gender;
          this.phone = parent.parent.phone;
          this.address = parent.parent.address;
        })
        .catch(err => {
          console.log(err);
        })
        .finally(() => (this.viewLoading = false));
    },

    deleteParent(id, index, e) {
      if (confirm("Are you sure?")) {
        var target, spinner;
        if (e.target.classList.contains("bg-danger")) {
          target = e.target;
          target.hidden = true;
          spinner = e.target.nextElementSibling;
          spinner.classList.remove("spinner-sm");
        } else if (e.target.classList.contains("fa-trash")) {
          target = e.target.parentElement;
          target.hidden = true;
          spinner = e.target.parentElement.nextElementSibling;
          spinner.classList.remove("spinner-sm");
        }

        let fd = new FormData();
        fd.append("id", id);
        Axios.post("/delete-parent", fd)
          .then(res => {
            let data = JSON.parse(res.data);
            if (data.error) {
              Swal.fire("Error!", data.message, "error");
            } else {
              this.spliceParent(index);
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

    setPages() {
      let numberOfPages = Math.ceil(this.parents.length / this.perPage);
      for (let index = 1; index <= numberOfPages; index++) {
        this.pages.push(index);
      }
    },
    paginate(parents) {
      let page = this.page;
      let perPage = this.perPage;
      let from = page * perPage - perPage;
      let to = page * perPage;
      return parents.slice(from, to);
    }
  },

  watch: {
    parents() {
      this.setPages();
    }
  },
  filters: {
    trimWords(value) {
      return (
        value
          .split(" ")
          .splice(0, 20)
          .join(" ") + "..."
      );
    }
  }
};
</script>


<style scoped>
i#spinner {
  font-size: 80px;
}

i.spinner-sm {
  display: none;
}

button.page-link {
  display: inline-block;
}
button.page-link {
  font-size: 20px;
  color: #29b3ed;
  font-weight: 500;
}
.offset {
  width: 500px !important;
  margin: 20px auto;
}
</style>