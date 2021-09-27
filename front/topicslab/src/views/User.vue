<template>
  <div>
    <div v-if="isloading">
      <Skeleton class="p-mb-2"></Skeleton>
    </div>
    <Card>
      <template #header>
          <img alt="user header" src="demo/images/usercard.png">
      </template>
      <template #title>
          {{user.name}}のページ
      </template>
      <template #content>
        <div class="fields">
          <label for="name">名前:</label>{{user.name}}<br>
          <label for="intro">自己紹介:</label><br>
          {{user.intro}}
        </div>
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
