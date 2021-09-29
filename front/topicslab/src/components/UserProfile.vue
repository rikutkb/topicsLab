<template>
    <p v-on:mouseover="mouseOverAction" v-on:mouseleave="mouseLeaveAction">
        <router-link :to="`/user/${user.id}`">
        {{user.name}}
      </router-link>
      <span class="user_img" v-if="user.img_path">
      <img :src= "'http://localhost:8000/' + user.img_path" :width="20" />
      </span>
      <span v-else class="dummy_img">aaa</span>
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

/*画像の代わり*/
.dummy_img{
  float:left;
  margin:0px 30px 0px 0px;
  width:150px;
  height:150px;
  color:#aaa;
  background-color:#aaa;
}
</style>
