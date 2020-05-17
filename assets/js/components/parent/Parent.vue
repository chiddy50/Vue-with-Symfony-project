<template>
  <div class>
    <Header :title="'Parents'" :title2="'Add New Parent'" />

    <div class="row">
      <div class="col-sm-12">
        <div class="card height-auto">
          <div class="card-body">
            <div class="heading-layout1">
              <div class="item-title">
                <h3>Add New Parent</h3>
              </div>
            </div>

            <form class="new-added-form" data-select2-id="18" @submit.prevent="addparent($event)">
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-12 form-group">
                  <label>Fullname *</label>
                  <input
                    type="text"
                    v-model="form.fullname"
                    name="fullname"
                    class="form-control rounded-0"
                  />
                </div>
                <div class="col-xl-6 col-lg-6 col-12 form-group">
                  <label>E-Mail</label>
                  <input
                    type="email"
                    name="email"
                    v-model="form.email"
                    class="form-control rounded-0"
                  />
                </div>
                <div class="col-xl-6 col-lg-6 col-12 form-group">
                  <label>Gender *</label>
                  <select
                    class="select2 form-control rounded-0"
                    name="gender"
                    v-model="form.gender"
                  >
                    <option value>Please Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="others">Others</option>
                  </select>
                </div>
                <div class="col-xl-6 col-lg-6 col-12 form-group">
                  <label>Phone</label>
                  <input
                    type="text"
                    v-model="form.phone"
                    name="phone"
                    class="form-control rounded-0"
                  />
                </div>
                <div class="col-lg-6 col-12 form-group">
                  <label for="address">Address</label>
                  <textarea
                    class="textarea form-control rounded-0"
                    name="address"
                    v-model="form.address"
                    id="form-message"
                    cols="10"
                    rows="9"
                  ></textarea>
                </div>

                <div class="col-12 form-group mg-t-8">
                  <button
                    type="submit"
                    class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark rounded-0"
                    :disabled="parentLoad"
                  >Save</button>
                  <button
                    type="reset"
                    class="btn-fill-lg bg-blue-dark btn-hover-yellow rounded-0"
                  >Reset</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
import { mapGetters, mapActions, mapState } from "vuex";
import Header from "../inc/Header.vue";

export default {
  name: "Parent",
  components: {
    Header
  },
  data() {
    return {
      form: {
        id: "",
        fullname: "",
        email: "",
        gender: "",
        address: "",
        phone: ""
      },
      parentLoad: false
    };
  },
  mounted() {
    this.getParents();
  },
  computed: {
    ...mapState(["parents", "parentLoading"])
  },
  methods: {
    ...mapActions(["getParents"]),

    addparent(e) {
      this.parentLoad = true;
      let formData = new FormData(e.target);
      Axios.post("/newparent", formData)
        .then(response => {
          console.log(response);
          let data = JSON.parse(response.data);
          if (data.error) {
            this.parentLoad = false;
            Swal.fire({
              position: "top-end",
              icon: "error",
              title: data.message,
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            this.parentLoad = false;
            this.$store.state.parents.push(data.parent);
            this.$router.push("allparents");
          }
        })
        .catch(err => {
          console.error(err);
        })
        .finally(() => (this.parentLoad = false));
    }
  }
};
</script>


<style scoped>
i#spinner {
  font-size: 80px;
}

textarea {
  resize: none;
}
</style>