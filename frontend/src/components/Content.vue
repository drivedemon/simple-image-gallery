<template>
  <router-view/>
</template>

<script>
export default {
  name: 'Content',
  data() {
    return {
      authenticated: this.authenticated,
    }
  },
}
</script>