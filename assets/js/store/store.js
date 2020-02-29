import Vuex from 'vuex';
import Vue from 'vue';
import state from './state';
import getters from './getters';
import actions from './actions';
import mutations from './mutations';
import Swal from 'sweetalert2'


Vue.use(Vuex);

export const store = new Vuex.Store({
    state,
    getters,
    mutations,
    actions
});

