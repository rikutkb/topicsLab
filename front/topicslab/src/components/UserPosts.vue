<template>
  <TabView>
    <TabPanel header="トピックス">
      <UserTopics :topics="this.topics" />
    </TabPanel>
    <TabPanel header="コメント">
      <UserComments :comments="this.comments" />
    </TabPanel>
  </TabView>
</template>

<script>
import UserTopics from '@/components/UserTopics'
import UserComments from '@/components/UserComments'
export default {
  name: 'UserPosts',
  commponents: {
    UserTopics,
    UserComments
  },
  props: {
    topics: Array,
    comments: Array
  }
}
</script>
