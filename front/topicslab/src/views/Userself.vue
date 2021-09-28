<template>
  <div>
    <div v-if="isloading">
      <Skeleton class="p-mb-2"></Skeleton>
    </div>
    <Card>
      <template #title>
        マイページ
      </template>
      <template #content>
        {{user.name}}
        <div class="fields">
          <label for="intro">自己紹介</label><br>
          <InputText id="intro" type="textarea" v-model="intro" />
        </div>
        <div class="p-field">
          <Button icon="pi pi-check" label="更新" v-on:click="submitIntro" />
        </div>
        <input type="file" @change="getImg" />
        <Button icon="pi pi-check" label="アップロード" v-on:click="uploadImg" />
      </template>
      <template #footer>
        <Button label="Create Topic" v-on:click="toNewTopic" />
        <Button label="Logout" class="p-button-warning" v-on:click="logout" />
        <Button label="Withdraw" class="p-button-danger" v-on:click="withdraw" />
      </template>
    </Card>
    <TabView>
      <TabPanel header="topics">
        <UserTopics :topics="user.topics" />
      </TabPanel>
      <TabPanel header="comments">
        <UserComments :comments="user.comments" />
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
          console.log('jfsdlfjsd')
          axios.post('/api/user/profile', data)
            .then((res) => {
              if (res.status === 200) {
                console.log(res.data)
              } else {
                console.log('取得失敗')
              }
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
</style>
