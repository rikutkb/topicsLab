<template>
  <div>
    <div v-if="isloading">
      <Skeleton height="163.17px" class="p-mb-2"></Skeleton>
    </div>
    <Card v-for="topic in topics" :key="topic.id">
        <template #content>
          <span class="topic-date">投稿日：{{moment(topic.created_at)}}<img v-if="topic.img_path" :src= "'http://localhost:8000/' + topic.img_path" :width="20" /></span>
          <h2>
            <router-link :to="`/topic/${topic.id}`">
              {{topic.title}}
            </router-link>
          </h2>
        </template>
    </Card>
    <Paginator :rows="10" :totalRecords="this.totalRecords" @page="onPage($event)"></Paginator>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import moment from 'moment'
export default {
  name: 'AllTopics',
  data () {
    return {
      totalRecords: Number,
      topics: [],
      isloading: true
    }
  },
  mounted () {
    this.getAllTopics()
  },
  methods: {
    moment: function (date) {
      return moment(date).format('YYYY/MM/DD HH:mm:SS')
    },
    getTopicsPage (targetPage) {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get(targetPage)
            .then((res) => {
              this.topics = []
              if (res.status === 200) {
                this.topics.splice(0)
                this.topics.push(...res.data.data)
                this.totalRecords = res.data.total
              } else {
                console.log('取得失敗')
              }
            })
        })
        .catch((err) => {
          alert(err)
        })
    },
    getAllTopics () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get('/api/topics')
            .then((res) => {
              console.log(res.data)
              console.log(res.data.data)
              if (res.status === 200) {
                this.topics.splice(0)
                this.topics.push(...res.data.data)
                this.totalRecords = res.data.total
                this.isloading = false
              } else {
                console.log('取得失敗')
              }
            })
        })
        .catch((err) => {
          alert(err)
        })
    },
    onPage (event) {
      this.getTopicsPage(`/api/topics?page=${event.page + 1}`)
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
/*スケルトン*/
.p-mb-2{
  margin-bottom: 20px;
}
</style>
