<template>
  <TabView>
    <TabPanel header="トピックス">
      <UserTopics :topics="topics" />
    </TabPanel>
    <TabPanel header="コメント">
      <UserComments :comments="comments" />
    </TabPanel>
  </TabView>
</template>
<script>
export default {
  name: 'UserPosts',
  props: {
    topics: Array,
    comments: Array
  }
}
</script>
