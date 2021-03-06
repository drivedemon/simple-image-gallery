<template>
  <router-view :key="$route.fullPath"/>
</template>

<script>
export default {
  name: 'Content',
  data: () => ({ authenticated: localStorage.status }),
}
</script>