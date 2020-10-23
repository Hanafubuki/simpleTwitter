<template>
  <div>
    <button class="btn btn-success ml-1" data-toggle="modal" data-target="#Login">Login</button>

    <div class="modal fade" id="Login" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title">Login</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input class="form-control mb-2" type="text" v-model="user.username" placeholder="Username">
            <input class="form-control mb-2" type="password" v-model="user.password" placeholder="Password">
            <div class="d-flex justify-content-center">
              <button class="btn btn-primary" @click="login">Login</button>
            </div>
            <div class="mt-1" v-for="(error,index) in errors">
              <div class="text-danger">{{error}}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  data() {
    return{
      user:{
        username:'',
        password:'',
      },
      errors:[],
    }
  },
  methods:{
    getErrors(){
      return this.errors;
    },
    login(){
      axios.post('/api/v1/auth/login/',this.user
                  ).then(res => {
                    this.$store.commit("changeToken", res.data.token);
                    $('#Login').modal('hide');
                  }).catch(err => {
                    this.errors = err.response.data.data;
                  });
    }
  },
}
</script>

<style>

</style>
