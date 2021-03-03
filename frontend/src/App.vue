<template>
  <div id="app">
    <Header/>
    <Content/>
  </div>
</template>

<script>
import Header from './components/Header.vue'
import Content from './components/Content.vue'

export default {
  name: 'App',
  components: {
    Header,
    Content
  },
  data() {
    return {
      authenticated: false,
    }
  },
  mounted() {
    if (localStorage.status) {
      this.$router.replace({name: "upload"});
    } else {
      this.$router.replace({name: "login"});
    }
  },
}
</script>

<style>
body {
  background-color: #F0F0F0;
}

h1 {
  padding: 0;
  margin-top: 0;
}
</style>