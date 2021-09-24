<template>
  <div>
    <Card v-for="topic in topics" :key="topic.id">
        <template #content>
          <span class="topic-date">投稿日：{{moment(topic.created_at)}}</span>
          <h2>
            <router-link :to="`/topic/${topic.id}`">
              {{topic.title}}
            </router-link>
          </h2>
        </template>
    </Card>
    <Paginator :rows="10" :totalRecords="totalItemsCount" @page="onPage($event)"></Paginator>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import moment from 'moment'

export default {
  name: 'AllTopics',
  data () {
    return {
      topics: []
    }
  },
  mounted () {
    this.getAllTopics()
  },
  methods: {
    moment: function (date) {
      return moment(date).format('YYYY/MM/DD HH:mm:SS')
    },
    getAllTopics () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get('/api/topics')
            .then((res) => {
              console.log(res.data.data)
              if (res.status === 200) {
                this.topics.splice(0)
                this.topics.push(...res.data.data)
              } else {
                console.log('取得失敗')
              }
            })
        })
        .catch((err) => {
          alert(err)
        })
    }
  },
  onPage (event) {
    console.log('eeee')
    console.log(event.page)
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
