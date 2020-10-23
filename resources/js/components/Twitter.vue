<template>
  <div>
    <UserBar :logged_in="logged_in" @logoutEvent="logout()" />
    <div class="container d-flex flex-column justify-content-center">
      <CreatePost @updatePosts="getPosts()" v-if="logged_in" />
      <Posts :posts="posts" v-if="logged_in" />
      <h2 class="text-info" v-else>Please login first!</h2>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
Vue.component('UserBar', require('./UserBar.vue').default);
Vue.component('CreatePost', require('./CreatePost.vue').default);
Vue.component('Posts', require('./Posts.vue').default);

export default {
  data() {
    return{
      logged_in: false,
      posts: [],
    }
  },
  computed: mapState(['token']),

  watch: {
    token(token){
      this.getPosts();
    }
  },

  methods:{
    getPosts(){
      let token = this.$store.state.token;
      fetch('/api/v1/tweets',{
          headers: {
            'Authorization': `Bearer ${token}`
          }
        })
          .then(res => res.json())
          .then(res => {
            if(res.message && res.message == "Unauthenticated."){
              return;
            }
            this.logged_in=true;
            this.posts = res.data;
          })
          .catch(err => {
              console.log(err);
              console.log(err.response.data);
          });
      },

      logout(){
        this.posts=[];
        this.logged_in=false;
      }
  }

}
</script>

<style>

</style>
