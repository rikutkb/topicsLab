<template>
  <div>
    <Fieldset v-for="comment in comments" :key="comment.id">
      <template #legend>
        <span><img v-if="comment.user.img_path" :src= "'http://localhost:8000/' + comment.user.img_path" :width="20" />{{comment.user.name}}</span>
      </template>
      <div class="comment-text">
        {{comment.body}}
      </div>
      <Button icon="pi pi-heart" label="いいね" class="p-button-rounded topic_like_btn" v-on:click="register_comment(comment.id)" />
      <div class="comment-like">
        いいね数：{{comment.comment_likes_count}}
      </div>
      <div class="userprofile">
      <UserProfile :user="comment.user" class="comment_user_icon" />
    </div>
    </Fieldset>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import UserProfile from '@/components/UserProfile'
export default {
  name: 'Comments',
  components: {
    UserProfile
  },
  props: {
    comments: Array,
    topicId: Number
  },
  methods: {
    register_comment (CommentId) {
      console.log('comment like')
      console.log(CommentId)
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post(`/api/topic/${this.topicId}/comment/${CommentId}`)
            .then((res) => {
              if (res.status >= 200 && res.status <= 300) {
                console.log(res)
              } else {
                console.log('取得失敗')
              }
            })
            .catch((err) => {
              console.log(err)
            })
        })
        .catch((err) => {
          alert(err)
        })
    }
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

.topic_like_btn{
  background: #F68;
  border: #F68;
  margin-top: 20px;
  float: left;
}
.topic_like_btn:hover{
  background: #E57;
  border: #E57;
}
.comment-like {
  padding-top: 30px;
  padding-left: 120px;
}
.userprofile{
  text-align: right;
  margin-bottom:0px;
}
</style>
