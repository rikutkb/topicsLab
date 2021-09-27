<template>
  <div>
    <div v-if="isloading">
      <Skeleton class="p-mb-2"></Skeleton>
    </div>
    <UserPosts :topics="user.topics" :comments="user.comments">
    </UserPosts>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import UserPosts from '@/components/UserPosts'
export default {
  name: 'user',
  components: {
    UserPosts
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
