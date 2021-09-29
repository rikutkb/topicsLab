<template>
  <Card>
    <template #title>
      新しいTopicを投稿しよう
    </template>
    <template #content>
      <div class="p-field">
        <label for="title">Topicタイトル</label>
        <InputText v-model="title" id="title" type="text" aria-describedby="title-help" />
        <small id="title-help">タイトルを入力してください。</small>
        <span style="color:red">{{messages.title}}</span>
      </div>
      <div class="p-field">
        <label for="title">Topic内容</label>
        <Textarea v-model="body" :autoResize="true" rows="10" />
        <span style="color:red">{{messages.body}}</span>
      </div>
      <input type="file" @change="getImg" />
      <div class="p-field">
        <Button label="確定" v-on:click="submit" />
        <span style="color:red">{{messages.submit}}</span>
      </div>
    </template>
  </Card>
</template>

<script>
import axios from '@/supports/axios'

export default {
  name: 'NewTopic',
  data () {
    return {
      title: '',
      body: '',
      messages: {
        submit: '',
        title: '',
        body: '',
        file: '',
        confirmedImage: ''
      }
    }
  },
  mounted () {
    if (localStorage.getItem('authenticated') !== 'true') {
      this.$router.push('login')
    }
  },
  methods: {
    getImg (e) {
      this.file = e.target.files[0]
      const reader = new FileReader()
      reader.readAsDataURL(this.file)
      reader.onload = e => {
        this.confirmedImage = e.target.result
      }
    },
    submit () {
      const title = this.title.trim()
      if (!title) {
        this.messages.title = '未記入(空白のみ)は送信できません。'
        alert(this.messages.title)
      }
      const body = this.body.trim()
      if (!body) {
        this.messages.body = '未記入(空白のみ)は送信できません。'
        alert(this.messages.title)
      }

      if (!title || !body) return
      const data = new FormData()
      data.append('file', this.file)
      data.set('title', title)
      data.set('body', body)
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/topic', data)
            .then((res) => {
              if (res.status === 201) {
                console.log(res)
              } else {
                this.messages.submit = '送信に失敗しました。'
                alert(this.messages.submit)
              }
            })
            .catch((err) => {
              console.log(err)
              this.messages.submit = '送信に失敗しました。'
              alert(this.messages.submit)
            })
        })
        .catch((err) => {
          alert('ネットワークエラー')
          console.log(err)
        })
    }
  }
}
</script>

<style scoped>
.p-field * {
  display: block;
  width: 100%;
}
</style>
