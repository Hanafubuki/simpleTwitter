<template>
  <div class="d-flex flex-column justify-content-center mb-2">
    <textarea class="form-control" rows="3" placeholder="Say something!"></textarea>
    <button class="btn btn-primary" @click="tweetPost">Tweet</button>
  </div>
</template>

<script>
export default {
  data() {
    return{
      tweet: '',
    }
  },

  methods:{
    tweetPost(){
      let token = this.$store.state.token;
      axios.post('/api/v1/tweets/',this.tweet,{
                  headers: {
                    'Authorization': `Bearer ${token}`
                  }
                }).then(res => {
                    this.$emit('updatePosts');
                  }).catch(err => {
                    this.errors = err.response.data.data;
                  });
    }
  },
}
</script>

<style>

</style>
