<template>
  <div id="nav">
    <router-link class="r_link_btn" to="/">ホーム</router-link> |
    <template v-if="authenticated">
      <router-link class="r_link_btn" to="/mypage">マイページ</router-link>
    </template>
    <template v-else>
      <router-link class="r_link_btn" to="/login">ログイン</router-link>
    </template>
  </div>
  <div class="content">
    <router-view/>
  </div>
  <div class="chosaku">
    <p><small>&copy; TopicsLab 2021</small></p>
  </div>
</template>

<script>
export default {
  data () {
    return {
      authenticated: false
    }
  },
  watch: {
    $route () {
      this.authenticated = localStorage.getItem('authenticated') === 'true'
    }
  }
}
</script>

<style lang="scss">
html, body {
  height: 100%;
  min-height: 100%;
}
.chosaku p{
    text-align: center;
  }
body {
  margin: 0;
  background: linear-gradient(-135deg, #E4A972, #9941D8);
  background-attachment: fixed;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;

  .content {
    max-width: 600px;
    width: 100%;
    margin: 0 auto;
    padding: 0 20px;
    padding-bottom: 20px;
  }
}

#nav {
  padding: 30px;

  /*a {
    font-weight: bold;
    color: purple !important;

    &.router-link-exact-active {
      color: #42b983;
    }
  }*/
}
/*上部のリンクボタン(ホーム/ログイン/マイページ)*/
.r_link_btn{
  text-decoration: none;
  font-weight: bold;
  color:white;
  opacity:1;
}
.r_link_btn:hover{
  opacity:0.5;
}
/*著作権表記*/
.chosaku{
  color:white;
}
</style>
