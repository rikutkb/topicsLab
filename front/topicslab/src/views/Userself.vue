<template>
  <div>
    <Card>
      <template #title>
        マイページ
      </template>
      <template #content>
        {{user.name}}
      </template>
      <template #footer>
        <Button label="新規トピック" v-on:click="toNewTopic" />
        <Button label="ログアウト" class="p-button-warning" v-on:click="logout" />
        <Button label="アカウント削除" class="p-button-danger" v-on:click="withdraw" />
      </template>
    </Card>
    <TabView>
      <TabPanel header="トピックス">
        <UserTopics :topics="user.topics" />
      </TabPanel>
      <TabPanel header="コメント">
        <UserComments :comments="user.comments" />
      </TabPanel>
      <TabPanel header="インフォ">
        名前:{{user.name}}<br>
        <div class="fields">
          <label for="intro">自己紹介</label><br>
          <InputText id="intro" type="textarea" v-model="intro" />
        </div>
        <div class="p-field">
          <Button icon="pi pi-check" label="更新" v-on:click="submitIntro" />
        </div>

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
      intro: '',
      user: {}
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
          axios.put('/api/user', {
            intro: this.intro
          })
            .then((res) => {
              console.log(this.intro)
              if (res.status === 200) {
                this.user = res.data
                console.log(this.user)
              } else {
                console.log('取得失敗')
              }
            })
        })
        .catch((err) => {
          alert(err)
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
                this.user = res.data
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
</style>
