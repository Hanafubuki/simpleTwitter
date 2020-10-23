<template>
  <div class="d-flex flex-column justify-content-center mb-2">
    <textarea class="form-control" rows="3" placeholder="Say something!" v-model="tweet.text"></textarea>
    <button class="btn btn-primary" @click="tweetPost">Tweet</button>
  </div>
</template>

<script>
export default {
  data() {
    return{
      tweet: {
        text: '',
      },
    }
  },

  methods:{
    tweetPost(){
      let token = this.$store.state.token;
      if(this.tweet == ''){
        return;
      }
      axios.post('/api/v1/tweets/',this.tweet,{
                  headers: {
                    'Authorization': `Bearer ${token}`
                  }
                }).then(res => {
                    this.tweet.text = "";
                    this.$emit('updatePosts');
                  }).catch(err => {
                    console.log(err.response.data)
                  });
    }
  },
}
</script>

<style>

</style>
