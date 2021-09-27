<template>
    <p v-on:mouseover="mouseOverAction" v-on:mouseleave="mouseLeaveAction">
        <router-link :to="`/user/${user.id}`">
        {{user.name}}
      </router-link>
    </p>
  <OverlayPanel ref="op" >
    名前:{{user.name}}<br>
    コメント数:{{user_obj.comments_num}}<br>
    トピック数:{{user_obj.topics_num}}
  </OverlayPanel>
</template>

<script>
import axios from '@/supports/axios'
export default {
  name: 'UserProfile',
  data () {
    return {
      user_obj: {}
    }
  },
  props: {
    user: Object
  },
  methods: {
    getSummary (id) {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get(`/api/user/${id}/summary`)
            .then((res) => {
              if (res.status === 200) {
                this.user_obj = res.data
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
    },
    mouseOverAction (event) {
      this.getSummary(1)
      this.$refs.op.toggle(event)
    },
    mouseLeaveAction (event) {
      this.$refs.op.toggle(event)
    }
  }
}
</script>

<style lang="scss" scoped>
.p-card.p-component {
  margin-bottom: 20px;
}
.p-card-content {
  .topic-date {
    font-size: 80%;
  }
}
</style>
