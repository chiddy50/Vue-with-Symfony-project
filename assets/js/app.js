import Vue from "vue";
import App from "./components/App";
import router from "./router.js";
import Axios from "axios";
import { store } from "./store/store.js";
import VueSwal from "vue-swal";

Vue.use(VueSwal);

Axios.defaults.baseURL = "http://schoolapp.test";

const app = new Vue({
  router,
  store,
  el: "#app",
  render: h => h(App)
});
