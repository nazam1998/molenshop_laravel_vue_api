import Vue from 'vue'
import Vuex from 'vuex';
import axios from 'axios';
import createPersistedState from "vuex-persistedstate";
import router from '../router'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    shops: null,
    currentUser: null,
    auth_token: null,
    message: null,
    myShop: null,
    myCart: null,
    orders: null,
  },
  mutations: {
    setShops: function (state, value) {
      state.shops = value;
    },
    setOrders: function (state, value) {
      state.orders = value.data;
    },
    setToken: function (state, value) {
      state.auth_token = value
    },
    setCurrentUser: function (state, value) {
      state.currentUser = value.data;
    },
    setMyShop: function (state, value) {
      state.myShop = value.data;
    },
    setMyCart: function (state, value) {
      state.myCart = value.data;
    },
    logout: function (state) {
      state.auth_token = null;
      state.currentUser = null;
    },
    setMessage: function (state, value) {
      state.message = value
    },
    emptyCart: function (state) {
      state.myCart = null
    }
  },
  getters: {
    shops: function (state) {
      return state.shops.data
    }
  },
  actions: {
    getShops: function ({
      commit,
      state
    }) {
      axios
        .get("http://127.0.0.1:8000/api/v1/shops", {
          headers: {
            Authorization: "Bearer " + state.auth_token
          }
        })
        .then((resp) => {
          commit('setShops', resp.data.data);
        })
        .catch((err) => {
          state.message = {
            'text': err.message,
            'type': 'error',
            'errors':err.response.data.errors
          };
        });
    },
    getOrders: function ({
      commit,
      state
    }) {
      axios
        .get("http://127.0.0.1:8000/api/v1/orders", {
          headers: {
            Authorization: "Bearer " + state.auth_token
          }
        })
        .then((resp) => {
          commit('setOrders', resp.data);
        })
        .catch((err) => {
          state.message = {
            'text': err.message,
            'type': 'error',
            'errors':err.response.data.errors
          };
        });
    },
    login: function ({
      commit,
      dispatch,
      state
    }, value) {
      axios.post('http://127.0.0.1:8000/api/v1/login', value).then((resp) => {
        commit('setToken', resp.data.data.token);
        dispatch('getUser');
        dispatch('getMyShop');
        dispatch('getMyCart');
        router.push({
          name: "Home"
        });

      }).catch((err) => {
        state.message = {
          'text': err.message,
          'type': 'error',
          'errors':err.response.data.errors
        };
      });
    },
    editPicture: function ({
      state,
      dispatch
    }, value) {
      axios.post('http://127.0.0.1:8000/api/v1/user/picture', value, {
        headers: {
          Authorization: "Bearer " + state.auth_token
        }
      }).then((rep) => {
        state.message = rep.message
        dispatch('getUser');
      }).catch((err) => {
        state.message = {
          'text': err.message,
          'type': 'error',
          'errors':err.response.data.errors
        };
      })
    },
    editProfile: function ({
      state,
      dispatch
    }, value) {
      axios.post('http://127.0.0.1:8000/api/v1/user', value, {
        headers: {
          Authorization: "Bearer " + state.auth_token
        }
      }).then((rep) => {

        state.message = rep.message
        dispatch('getUser');
      }).catch((err) => {
        state.message = {
          'text': err.message,
          'type': 'error',
          'errors':err.response.data.errors
        };
      })
    },
    async getUser({
      commit,
      state
    }) {
      await axios.get('http://127.0.0.1:8000/api/v1/user', {
        headers: {
          Authorization: "Bearer " + state.auth_token
        }
      }).then((response) => {
        commit('setCurrentUser', response.data)
      }).catch((err) => {
        state.message = {
          'text': err.message,
          'type': 'error',
          'errors':err.response.data.errors
        };
      });
    },
    addToCart({
      state,
      dispatch
    }, value) {

      axios.post('http://127.0.0.1:8000/api/v1/cart', value, {
        headers: {
          Authorization: "Bearer " + state.auth_token
        }
      }).then((
        resp
      ) => {
        state.message = {
          'text': resp.data.message,
          'type': 'success'
        };
        dispatch('getMyShop')
        dispatch('getShops')
        dispatch('getMyCart')
      }).catch((err) => {
        state.message = {
          'text': err.message,
          'type': 'error',
          'errors':err.response.data.errors
        };
      })
    },
    removeFromCart({
      state,
      dispatch
    }, value) {

      axios.delete('http://127.0.0.1:8000/api/v1/cart/' + value, {
        headers: {
          Authorization: "Bearer " + state.auth_token
        }
      }).then((
        resp
      ) => {
        state.message = {
          'text': resp.data.message,
          'type': 'success'
        };
        dispatch('getMyShop')
        dispatch('getShops')
        dispatch('getMyCart')
      }).catch((err) => {
        state.message = {
          'text': err.message,
          'type': 'error',
          'errors':err.response.data.errors
        };
      })
    },
    confirmOrder: function ({
      dispatch,
      commit,
      state
    }) {
      axios.post('http://127.0.0.1:8000/api/v1/buy', {}, {
        headers: {
          Authorization: "Bearer " + state.auth_token
        }
      }).then((resp) => {
        dispatch('getMyCart');
        state.message = {
          'text': resp.data.message,
          'type': 'success'
        };
        commit('emptyCart')
      }).catch((err) => {
        console.log(err.data);
        state.message = {
          'text': err.message,
          'type': 'error',
          'errors':err.response.data.errors
        };
      });
    },
    addProduct({
      state,
      dispatch
    }, value) {
      axios.post('http://127.0.0.1:8000/api/v1/product', value, {
        headers: {
          Authorization: "Bearer " + state.auth_token
        }
      }).then(() => {
        dispatch('getMyShop')
      }).catch((err) => {
        console.log(err.data);
        state.message = {
          'text': err.message,
          'type': 'error',
          'errors':err.response.data.errors
        };
      })
    },
    editProduct({
      state,
      dispatch
    }, value) {

      let data = value[0];
      let product_id = value[1];
      axios.post('http://127.0.0.1:8000/api/v1/product/' + product_id, data, {
        headers: {
          Authorization: "Bearer " + state.auth_token
        }
      }).then((

      ) => {
        dispatch('getMyShop')
      }).catch((err) => {
        console.log(err.data);
        state.message = {
          'text': err.message,
          'type': 'error',
          'errors':err.response.data.errors
        };
      })
    },
    editProductPicture({
      state,
      dispatch
    }, value) {
      let data = value[0];
      let product_id = value[1];
      axios.post('http://127.0.0.1:8000/api/v1/product/' + product_id + '/picture', data, {
        headers: {
          Authorization: "Bearer " + state.auth_token
        }
      }).then((

      ) => {
        dispatch('getMyShop')
      }).catch((err) => {
        console.log(err.data);
        state.message = {
          'text': err.message,
          'type': 'error',
          'errors':err.response.data.errors
        };
      })
    },
    deleteProduct({
      state,
      dispatch
    }, value) {

      axios.delete('http://127.0.0.1:8000/api/v1/product/' + value, {
        headers: {
          Authorization: "Bearer " + state.auth_token
        }
      }).then((

      ) => {
        dispatch('getMyShop')
      }).catch((err) => {
        console.log(err.data);
        state.message = {
          'text': err.message,
          'type': 'error',
          'errors':err.response.data.errors
        };
      })
    },
    async getMyShop({
      commit,
      state
    }) {
      await axios.get('http://127.0.0.1:8000/api/v1/shop', {
        headers: {
          Authorization: "Bearer " + state.auth_token
        }
      }).then((response) => {
        commit('setMyShop', response.data)
      }).catch((err) => {
        console.log(err.data);
        state.message = {
          'text': err.message,
          'type': 'error',
          'errors':err.response.data.errors
        };
      });
    },
    async getMyCart({
      commit,
      state
    }) {
      await axios.get('http://127.0.0.1:8000/api/v1/cart', {
        headers: {
          Authorization: "Bearer " + state.auth_token
        }
      }).then((response) => {
        commit('setMyCart', response.data)
      }).catch((err) => {
        console.log(err.data);
        state.message = {
          'text': err.message,
          'type': 'error',
          'errors':err.response.data.errors
        };
      });
    },
  },
  modules: {

  },
  plugins: [createPersistedState({
    paths: ['currentUser', 'auth_token'],
  })],
})