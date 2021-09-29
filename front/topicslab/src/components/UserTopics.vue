<template>
  <div>
    <Card v-for="topic in topics" :key="topic.id">
        <template #content>
          <span class="topic-date">投稿日：{{moment(topic.created_at)}}</span>
          <h2>
            <router-link :to="`/topic/${topic.id}`" class="topictitle">
              {{topic.title}}
            </router-link>
          </h2>
        </template>
    </Card>
  </div>
</template>

<script>
import moment from 'moment'
export default {
  name: 'UserTopics',
  props: {
    topics: Array
  },
  methods: {
    moment: function (date) {
      return moment(date).format('YYYY/MM/DD HH:mm:SS')
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
.topictitle{
  color:#a4a;
  text-decoration: none;
}
.topictitle:hover{
  color:#505;
}
</style>
