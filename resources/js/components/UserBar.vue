<template>
  <div class="navbar">
    <div class="container">
      <h1>Simple Twitter</h1>
      <div class="d-flex justify-content-between navbar-links" v-if="!this.logged_in">
        <Register />
        <Login />
      </div>

      <div v-else>
        <button class="btn btn-secondary" @click="logout">Logout</button>
      </div>
    </div>
  </div>
</template>

<script>
Vue.component('Register', require('./User/Register.vue').default);
Vue.component('Login', require('./User/Login.vue').default);
export default {
  props: ['logged_in'],
  data() {
    return{
      request: {token: '',},
    }
  },
  methods:{
    logout(){
      let token = this.$store.state.token;
      this.request.token = token;
      axios.post('/api/v1/auth/logout',this.request,{
                  headers: {
                    'Authorization': `Bearer ${token}`
                  }
                }).then(res => {
                    this.$store.commit("changeToken", '');
                    this.$emit('logoutEvent');
                    localStorage['token'] = '';
                  }).catch(err => {
                    console.log(err.response)
                    this.errors = err.response.data.data;
                  });
    }

  }
}
</script>

<style>
  .navbar{
    background-color: #85D2E3;
    padding: 20px;
    margin-bottom: 20px;
  }
  .navbar-links{
    width: 130px;
  }
</style>
