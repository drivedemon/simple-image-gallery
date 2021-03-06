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
      defaultPath: ['login', 'register'],
      authenticated: localStorage.getItem('status') ?? false,
    }
  },
  mounted() {
    if (localStorage.status) {
      this.$router.replace({name: this.$router.currentRoute.name})
    } else {
      const currentPath = this.defaultPath.find(path => path === this.$router.currentRoute.name)
      this.$router.replace({name: currentPath ?? 'login'})
    }
  },
}
</script>

<style scoped>
</style>