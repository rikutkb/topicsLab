<template>
  <div>
    <Card>
      <template #title>
        {{topic.title}}
        <div v-if="isloading"><Skeleton height="35px" class="p-mb-2"></Skeleton></div>
      </template>
      <template #content>
        <div class="body-text">
          <div v-if="isloading"><Skeleton style="margin-bottom:5px;" height="20px" class="p-mb-2"></Skeleton></div>
          <div v-if="isloading"><Skeleton height="20px" class="p-mb-2"></Skeleton></div>
          {{topic.body}}<!--{{topic.topic_likes_count}}-->
        </div>
        <img v-if="topic.img_path" :src= "'http://localhost:8000/' + topic.img_path" :width="528" />
      </template>
      <template #footer>
        <Button icon="pi pi-heart" :label="'いいね ' + (topic_likes_count ? topic_likes_count : '' ) " class="p-button-rounded topic_like_btn" v-on:click="register"/>
          <div class="user_name">
              <div class="userprofile">
                <UserProfile :user="this.user" />
              </div>
              <div class="blank">a</div>
          </div>
      </template>
    </Card>
    <Comments :comments="this.comments" :topicId="this.topic.id"/>
    <CommentForm :topicId="this.topic.id" @sentComment="receiveComment" />
  </div>
</template>

<script>
import axios from '@/supports/axios'
import Comments from '@/components/Comments'
import CommentForm from '@/components/CommentForm'
import UserProfile from '@/components/UserProfile'
export default {
  name: 'Topic',
  components: {
    Comments,
    CommentForm,
    UserProfile
  },
  data () {
    return {
      topic: {},
      user: {},
      comments: [],
      id: null,
      isloading: true,
      topic_likes_count: null
    }
  },
  mounted () {
    if (localStorage.getItem('authenticated') !== 'true') {
      this.$router.push('/login')
      return
    }
    this.id = this.$route.params.id
    if (!this.id) {
      alert('不正なIDです。')
    }
    this.getTopic()
  },
  methods: {
    register () {
      console.log('topic like')
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post(`/api/topic/${this.id}/topiclike`)
            .then((res) => {
              if (res.status >= 200 && res.status <= 300) {
                console.log(res)
              } else {
                alert('トピック登録失敗')
              }
            })
            .catch((err) => {
              alert('サーバーエラー')
              console.log(err)
            })
        })
        .catch((err) => {
          alert('ネットワークエラー')
          console.log(err)
        })
    },
    getTopic () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get(`/api/topic/${this.id}`)
            .then((res) => {
              console.log(res.data)
              if (res.status === 200 && res.data.length === 1) {
                this.topic = res.data[0]
                this.user = this.topic.user
                this.comments.splice(0)
                this.comments.push(...this.topic.comments)
                this.isloading = false
                this.topic_likes_count = this.topic.topic_likes_count
              } else {
                alert('トピック取得失敗')
              }
            })
            .catch((err) => {
              alert('サーバーエラー')
              console.log(err)
            })
        })
        .catch((err) => {
          alert('ネットワークエラー')
          console.log(err)
        })
    },
    receiveComment (comment) {
      this.comments.push(comment)
    }
  }
}
</script>

<style scoped>
.body-text {
  white-space:pre-wrap;
}
.p-card-footer span {
  text-align: right;
  display: block;
}
.topic_like_btn{
  background: #F68;
  border: #F68;
  float: left;
}
.topic_like_btn:hover{
  background: #E57;
  border: #E57;
}
.topic-like{
  padding-top: 10px;
  padding-left: 120px;
}
.userprofile{
  clear: both;
  text-align: right;
}

/*ダミーのアイコン*/
.dummy_icon{
  float: right;
  width: 20px;
  height: 20px;
  color: #aaa;
  background-color: #aaa;
}
/*floatを解除する用*/
.blank{
  clear: both;
  color: #fff;
}
</style>
