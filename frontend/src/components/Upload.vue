<template>
  <div class="app">
    <vue-dropzone id="upload" :options="config"></vue-dropzone>
  </div>
</template>

<script>
import vueDropzone from "vue2-dropzone"

export default {
  data: () => ({
    config: {
      url: "http://localhost:8000/api/detail"
    }
  }),
  components: {
    vueDropzone
  }
};
</script>

<style scoped>
</style>
