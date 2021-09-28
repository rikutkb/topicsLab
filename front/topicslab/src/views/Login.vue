<template>
  <div>
    <Card>
      <template #title>
        ログイン
      </template>
      <template #content>
        <div class="fields">
          <div class="p-field">
            <label for="email">メールアドレス</label>
            <InputText id="email" type="email" v-model="email" />
          </div>
          <div class="p-field">
            <label for="password">パスワード</label>
            <InputText id="password" type="password" v-model="password" />
          </div>
        <!--<button onclick="location.href='Register'">新規登録はこちら</button>-->
        <span style="color:red">{{message}}</span>
        <div class="p-field">
          <Button icon="pi pi-check" label="ログイン" v-on:click="login" />
          <Button label="新規登録はこちら" onclick="location.href='Register'" class="p-button p-component p-button-secondary" type="button" style="margin-top:8px;" />
        </div>
        </div>
      </template>
    </Card>
  </div>
</template>

<script>
import axios from '@/supports/axios'

export default {
  name: 'Login',
  data () {
    return {
      email: '',
      password: '',
      error: false,
      message: ''
    }
  },
  methods: {
    login () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/login', {
            email: this.email,
            password: this.password
          })
            .then((res) => {
              if (res.status === 200) {
                localStorage.setItem('authenticated', 'true')
                this.$router.push('/Mypage')
              }
            })
            .catch((err) => {
              if (err.response.status === 410) {
                this.message = 'すでに削除されているユーザです。'
                alert(this.message)
              } else if (err.response.status === 401) {
                this.message = 'ログインに失敗しました。'
                alert(this.message)
              }
            })
        })
        .catch((err) => {
          alert(err)
        })
    }
  }
}
</script>

<style lang="scss" scoped>
.p-card-content {
  .fields {
    text-align: center;
  }

  .p-field {
    display: block;

    label {
      display: inline-block;
      width: 10em;
      margin-bottom: 10px;
    }

    .p-button {
      margin-top: 20px;
      display: block;
      width: 100%;
    }
  }
}
</style>
