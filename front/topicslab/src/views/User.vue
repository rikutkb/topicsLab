<template>
  <div>
    <Card>
      <template #title>
        <Skeleton width="30%" height="30px" class="p-mb-2 skeleton_inline" v-if="isloading"></Skeleton>{{user.name}}のページ
      </template>-->
      <template #content>
        <!--<img alt="user header" src="demo/images/usercard.png">-->
        <div class="user_img" v-if="user.img_path">
        <img :src= "'http://localhost:8000/' + user.img_path" :width="150" />
        </div>
        <div v-else class="dummy_img">aaa</div>
          <span class="u_name">{{user.name}}</span>
          <Skeleton width="20%" height="30px" class="p-mb-2 skeleton_inline" v-if="isloading"></Skeleton><br>
          <Skeleton width="63%" height="20px" class="p-mb-2 skeleton_block" v-if="isloading"></Skeleton>
          <Skeleton width="63%" height="20px" class="p-mb-2 skeleton_block" v-if="isloading"></Skeleton>
          <Skeleton width="63%" height="20px" class="p-mb-2 skeleton_block" v-if="isloading"></Skeleton>
          <Skeleton width="63%" height="20px" class="p-mb-2" v-if="isloading"></Skeleton>
          <div class="user_intro">
            {{user.intro}}
          </div>
        <div class="blank">a</div>
      </template>
    </Card>
    <TabView>
      <TabPanel header="トピックス">
        <UserTopics :topics="user.topics" />
        <div v-if="isloading"><Skeleton height="163.17px" class="p-mb-2"></Skeleton></div>
      </TabPanel>
      <TabPanel header="コメント">
        <UserComments :comments="user.comments" />

        <div v-if="isloading"><Skeleton height="163.17px" class="p-mb-2"></Skeleton></div>
      </TabPanel>
    </TabView>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import UserComments from '@/components/UserComments'
import UserTopics from '@/components/UserTopics'
export default {
  name: 'user',
  components: {
    UserComments,
    UserTopics
  },
  data () {
    return {
      id: null,
      user: {},
      isloading: true
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
    console.log(this.user)
    this.getUser()
  },
  methods: {
    getUser () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get(`/api/user/${this.id}`)
            .then((res) => {
              console.log(res.data.intro)
              if (res.status === 200) {
                this.user = res.data
                this.isloading = false
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
/**/
Skeleton{
  margin-left:0;
}
/*名前のダミー*/
.skeleton_inline{
  display:inline-block;
  margin:0px 5px;
}
/*自己紹介のダミー(上段)*/
.skeleton_block{
  margin-bottom: 5px;
}
.user_img{
  float:left;
  margin:0px 30px 0px 0px;
}
/*画像の代わり*/
.dummy_img{
  float:left;
  margin:0px 30px 0px 0px;
  width:150px;
  height:150px;
  color:#aaa;
  background-color:#aaa;
}
/*float解除用*/
.blank{
  clear: both;
  color:#fff;
  font-size:1px;
}
/*ユーザーの名前*/
.u_name{
  margin-bottom:100px;
  font-size:25px;
  font-weight:bold;
}
/**/
.user_intro{
  margin-top: 20px;
  width:95%;
}
</style>
