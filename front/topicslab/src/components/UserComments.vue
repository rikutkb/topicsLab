<template>
  <div>
    <Fieldset v-for="comment in comments" :key="comment.id">
      <div class="comment-text">
            {{comment.body}}<br>
            <router-link :to="`/topic/${comment.topic_id}`" class="topiclink">このトピックへ
            </router-link>
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

.topiclink {
color:rgb(0, 132, 255);
}
.topiclink:visited{
  color : #c340ff;
}
.topiclink:hover {
color:#ff7043;
}

</style>
