<template>
  <div class="upload">
    <div class="container">
      <file-upload/>
    </div>
  </div>
</template>

<script>
import Upload from "@/components/Upload";

export default {
  name: 'FileUpload',
  components: {
    'file-upload': Upload
  },
  data() {
    return {};
  },
}
</script>

<style scoped>
.upload {
  background-color: #FFFFFF;
  border: 1px solid #CCCCCC;
  padding: 20px;
  margin-top: 10px;
}
</style>