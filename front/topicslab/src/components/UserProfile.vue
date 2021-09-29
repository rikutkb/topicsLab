<template>
    <p v-on:mouseover="mouseOverAction" v-on:mouseleave="mouseLeaveAction">
      <span class="user_img" v-if="user.img_path">
      <img :src= "'http://localhost:8000/' + user.img_path" :width="20" />
      </span>
      <span v-else class="dummy_img">a</span>
      <router-link class="user_name_r" :to="`/user/${user.id}`">
        {{user.name}}
      </router-link>
    </p>

  <OverlayPanel ref="op" >
    名前:{{user.name}}<br>
    コメント数:{{user_obj.comments_count}}<br>
    トピック数:{{user_obj.topics_count}}
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
                alert('取得失敗')
              }
            })
            .catch((err) => {
              alert('サーバーエラー')
              console.log(err)
            })
        })
        .catch((err) => {
          alert('ネットワークエラー')
          console.log(err)
        })
    },
    mouseOverAction (event) {
      this.getSummary(this.user.id)
      console.log(this.user)
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

/*アバター画像*/
.user_img{
  margin-right:5px;
}

/*画像の代わり*/
.dummy_img{
  float:right;
  display: block;
  width:20px;
  height:20px;
  color:#aaa;
  background-color:#aaa;
}

.user_name_r{
  color:#838;
  font-weight:bold;
  text-decoration: none;
}
.user_name_r:hover{
  color:#505;
}
</style>
