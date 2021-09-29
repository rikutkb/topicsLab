<template>
  <div>
    <Card>
      <template #content>
        <div class="p-field">
          <Textarea v-model="comment" :autoResize="true" rows="5" />
          <p>{{message}}</p>
        </div>
        <div class="p-field">
          <Button label="コメントする" v-on:click="submit" />
        </div>
      </template>
    </Card>
  </div>
</template>

<script>
import axios from '@/supports/axios'

export default {
  name: 'CommentForm',
  props: {
    topicId: Number
  },
  data () {
    return {
      comment: '',
      message: ''
    }
  },
  methods: {
    submit () {
      const comment = this.comment.trim()
      if (!comment) {
        this.message = '未記入(空白のみ)は送信できません。'
        alert(this.message)
        return
      }

      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/comment', {
            topicId: this.topicId,
            body: comment
          })
            .then((res) => {
              if (res.status === 201) {
                this.comment = ''
                this.$emit('sentComment', res.data)
              } else {
                this.message = '送信に失敗しました。'
                alert(this.message)
              }
            })
            .catch((err) => {
              console.log(err)
              this.message = '送信に失敗しました。'
              alert(this.message)
            })
        })
        .catch((err) => {
          alert(err)
        })
    }
  }
}
</script>

<style scoped>
.p-card.p-component {
  margin-top:  20px;
}
.p-field * {
  display: block;
  width: 100%;
}
</style>
