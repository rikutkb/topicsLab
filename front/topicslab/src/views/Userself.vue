<template>
  <div>
    <Card>
      <template #title>
        <div id="title_top">
        マイページ
        <Button label="ログアウト" class="p-button logout_btn" v-on:click="logout" />
        </div>
      </template>
      <template #content id="username">
        <div class="user_img" v-if="user.img_path">
        <img :src= "'http://localhost:8000/' + user.img_path" :width="150" />
        </div>
        <div v-else class="dummy_img">aaa</div>
        <span class="u_name">{{user.name}}</span>
        <div v-if="isloading"><Skeleton width="30%" height="25px" class="p-mb-2"></Skeleton></div><br>
          <label class="textarea_des" for="intro">自己紹介</label><br>
          <InputText id="intro" type="textarea" v-model="intro" />
          <Button id="intro_btn" label="更新" v-on:click="submitIntro" />
          <div class="blank">a</div>
        <input type="file" @change="getImg" />
        <Button icon="pi pi-check" label="アップロード" v-on:click="uploadImg" />
      </template>
      <template #footer>
        <Button label="トピック作成" class="p-button create_btn" v-on:click="toNewTopic" />
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
    <Button label="アカウント削除" class="p-button withdraw_btn" v-on:click="withdraw" />
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
      intro: '',
      confirmedImage: '',
      file: '',
      ImgState: false
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
    submitIntro () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/user/profile', {
            intro: this.intro
          })
            .then((res) => {
              if (res.status === 200) {
                this.user = res.data
                this.$router.go({ path: '/Mypage', force: true })
              } else {
                alert('自己紹介を送信できませんでした。')
              }
            })
        })
        .catch((err) => {
          alert('ネットワークエラー')
          console.log(err)
        })
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
              alert('ログアウトできません。')
              console.log(err)
            })
        })
        .catch((err) => {
          console.log(err)
          alert('ネットワークエラー')
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
              alert('サーバーエラー')
            })
        })
        .catch((err) => {
          console.log(err)
          alert('ネットワークエラー')
        })
    },
    getImg (e) {
      this.file = e.target.files[0]
      const reader = new FileReader()
      reader.readAsDataURL(this.file)
      reader.onload = e => {
        this.confirmedImage = e.target.result
      }
    },
    uploadImg () {
      const data = new FormData()
      data.append('file', this.file)

      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/user/profile', data)
            .then((res) => {
              if (res.status === 200) {
                this.$router.go({ path: '/Mypage', force: true })
              } else {
                alert('画像送信に失敗しました。')
              }
            })
        })
        .catch((err) => {
          console.log(err)
          alert('サーバーエラー')
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
                alert('ユーザー取得失敗')
              }
            })
        })
        .catch((err) => {
          console.log(err)
          alert('サーバーエラー')
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
/*テキストエリアの説明*/
.textarea_des{
  margin-top:20px;
  font-size:13px;
}
/*テキストエリア*/
#intro{
  width:50%;
  height:50px;
  font-size:13px;
}
/*テキストエリアの更新ボタン*/
#intro_btn{
  height:50px;
}
/*ログアウトボタンを右に寄せるためのやつ*/
#title_top{
  display: flex;
}
/*ログアウトボタン*/
.logout_btn{
  margin-left: auto;
  background:#bbb;
  border-color:#bbb;
}
.logout_btn:hover{
  background:#aaa;
  border-color:#aaa;
}
/*トピック作成ボタン*/
.create_btn{
  width:100%;
}
/*削除ボタン*/
.withdraw_btn{
  width:100%;
  height:50px;
  color:#fff;
  background-color:#d00;
  border-color:#d00;
}
.withdraw_btn:hover{
  background-color:#b00;
  border-color:#b00;
}
</style>
