<template>
  <div>
    <Card>
      <template #title>
        マイページ
      </template>
      <template #content id="username">
        <div class="dummy_img">aaa</div>
        <span class="u_name">{{user.name}}</span>
        <div v-if="isloading"><Skeleton width="30%" height="25px" class="p-mb-2"></Skeleton></div><br>
          <label class="textarea_des" for="intro">自己紹介</label><br>
          <InputText id="intro" type="textarea" v-model="intro" />
          <Button id="intro_btn" label="更新" v-on:click="submitIntro" />
        <div class="blank">a</div>
      </template>
      <template #footer>
        <Button label="トピック作成" v-on:click="toNewTopic" />
        <Button label="ログアウト" class="p-button-warning" v-on:click="logout" />
        <Button label="アカウント削除" class="p-button-danger" v-on:click="withdraw" />
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
  name: 'Userself',
  components: {
    UserComments,
    UserTopics
  },
  data () {
    return {
      user: {},
      isloading: true,
      intro: ''
    }
  },
  mounted () {
    if (localStorage.getItem('authenticated') !== 'true') {
      this.$router.push('/login')
      return
    }

    this.getUser()
  },
  methods: {
    toNewTopic () {
      this.$router.push('topic')
    },
    logout () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/logout')
            .then(res => {
              console.log(res)
              localStorage.setItem('authenticated', 'false')
              this.$router.push('/login')
            })
            .catch(err => {
              console.log(err)
            })
        })
        .catch((err) => {
          alert(err)
        })
    },
    withdraw () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/withdraw')
            .then(res => {
              console.log(res)
              localStorage.setItem('authenticated', 'false')
              this.$router.push('/')
            })
            .catch(err => {
              console.log(err)
            })
        })
        .catch((err) => {
          alert(err)
        })
    },
    getUser () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get('/api/user')
            .then((res) => {
              if (res.status === 200) {
                console.log(res.data)
                this.user = res.data
                this.isloading = false
                this.intro = res.data.intro
              } else {
                console.log('取得失敗')
              }
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
.p-card-footer {
  .p-button {
    margin-right: 10px;
  }
}
/*画像の代わり*/
.dummy_img{
  float:left;
  margin:0px 30px 0px 0px;
  width:150px;
  height:150px;
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
/*テキストエリアの説明*/
.textarea_des{
  font-size:13px;
}
/*テキストエリア*/
#intro{
  height:50px;
}
/*テキストエリアの更新ボタン*/
#intro_btn{
  height:50px;
}
</style>
