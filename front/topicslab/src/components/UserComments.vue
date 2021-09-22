<template>
  <div>
    <Fieldset v-for="comment in comments" :key="comment.id">
      <div class="comment-text">
        {{comment.body}}
      </div>
    </Fieldset>
  </div>
</template>

<script>
export default {
  name: 'UserComments',
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
