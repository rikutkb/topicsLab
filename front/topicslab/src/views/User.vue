<template>
  <div>
    <TabView>
      <TabPanel header="topics">
        <UserTopics :topics="user.topics" />
      </TabPanel>
      <TabPanel header="comments">
        <UserComments :comments="user.comments" />
      </TabPanel>
      <TabPanel header="info">
        name:{{user.name}}<br>
        <div class="fields">
          <label for="intro">イントロ</label><br>
          {{user.intro}}
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
  name: 'user',
  components: {
    UserComments,
    UserTopics
  },
  data () {
    return {
      id: null,
      user: {}
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
