<template>
  <div>
    <button class="btn btn-primary" data-toggle="modal" data-target="#Register">Register</button>

    <div class="modal fade" id="Register" tabindex="-1" role="dialog" aria-labelledby="Register" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title">Create new account</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input class="form-control mb-2" type="text" v-model="user.name" placeholder="Name">
            <input class="form-control mb-2" type="text" v-model="user.username" placeholder="Username">
            <input class="form-control mb-2" type="email" v-model="user.email" placeholder="Email">
            <input class="form-control mb-2" type="password" v-model="user.password" placeholder="Password">
            <input class="form-control mb-2" type="password" v-model="user.password_confirmation" placeholder="Password confirmation">
            <div class="d-flex justify-content-center">
              <button class="btn btn-primary" @click="register">Register</button>
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
        name:'',
        username:'',
        email:'',
        password:'',
        password_confirmation:'',
      },
      errors:[],
    }
  },
  methods:{
    getErrors(){
      return this.errors;
    },
    register(){
      axios.post('/api/v1/auth/register/',this.user
                  ).then(res => {
                    this.$store.commit("changeToken", res.data.token);
                    localStorage['token'] = res.data.token;
                    $('#Register').modal('hide');
                  }).catch(err => {
                    this.errors = err.response.data.data;
                  });
    }
  },
}
</script>

<style>

</style>
