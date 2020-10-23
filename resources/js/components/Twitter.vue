<template>
  <div>
    <UserBar :logged_in="logged_in" @logoutEvent="logout()" />
    <div class="container d-flex flex-column justify-content-center">
      <CreatePost @updatePosts="updatePosts()" v-if="logged_in" />
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
      posts: '',
      next_page: '',
    }
  },
  computed: mapState(['token']),

  mounted(){
    var stored = localStorage['token'];
    if (stored){
      this.$store.commit("changeToken", stored);
    }
  },
  watch: {
    token(token){
      this.getPosts();
    }
  },

  methods:{
    getPosts(page_url = null){
      let vm = this;
      let token = this.$store.state.token;
      page_url = page_url || '/api/v1/tweets';
      fetch(page_url,{
          headers: {
            'Authorization': `Bearer ${token}`
          }
        })
          .then(res => res.json())
          .then(res => {
            if(res.message && res.message == "Unauthenticated."){
              return;
            }
            this.updateStatus(res)
          })
          .catch(err => {
              console.log(err);
              console.log(err.response.data);
          });
      },

      updateStatus(res){
        this.logged_in=true;
        if(this.posts.length == 0){
          this.posts = res.data
        }else{
          for(let i = 0; i < res.data.length; i++){
            this.posts.push(res.data[i])
          }
        };
        this.next_page = (JSON.parse(JSON.stringify(res.links)).next);
        this.scroll();
      },

      scroll () {
          window.onscroll = () => {
            let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;
              if (bottomOfWindow) {
                  let vm = this;
                  let page_url = this.next_page;
                  if(page_url !== null){
                      this.getPosts(page_url);
                  }
              }
          };
      },

      updatePosts(){
        this.posts='';
        this.getPosts();
      },

      logout(){
        this.posts=[];
        this.logged_in=false;
      },
  }

}
</script>

<style>

</style>
