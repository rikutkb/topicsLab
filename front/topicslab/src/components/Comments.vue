<template>
  <div>
    <Fieldset v-for="comment in comments" :key="comment.id">
      <template #legend>
        <span>{{comment.user.name}}</span>
      </template>
      <div class="comment-text">
        {{comment.body}}
      </div>
      <router-link :to="`/user/${comment.user.id}`">{{comment.user.name}}</router-link>
    </Fieldset>
  </div>
</template>

<script>
export default {
  name: 'Comments',
  props: {
    comments: Array
  }
}
</script>

<style lang="scss" scoped>
.p-fieldset {
  margin-top: 20px;
}

.comment-text {
  white-space:pre-wrap;
}
</style>
