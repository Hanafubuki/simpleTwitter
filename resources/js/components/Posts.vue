<template>
  <div>
    <h2 class="text-primary">Posts</h2>
    <div v-for="(post,index) in posts">
      <div class="card my-1">
        <div class="card-body">
          <p class="text-muted font-weight-bold">{{JSON.parse(JSON.stringify(post.author)).name}}</p>
          {{post.text}}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['posts']
}
</script>

<style>


</style>
