<template>
  <div id="dashboard">
    <div class="card mb-3">
      <div class="card-header">
        Disk Usage Overview
      </div>
      <div class="card-body">
        <table style="width: 100%" class="table">
          <thead>
          <tr>
            <th style="width: 30%"></th>
            <th style="width: 70%"></th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>Total Size:</td>
            <td>{{ `${formatBytes(totalSize)}(${totalSize})B` }}</td>
          </tr>
          <tr>
            <td>No of files:</td>
            <td>{{ totalFile }}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        Disk Usage Compositions
      </div>
      <div class="card-body">
        <table class="table" v-if="totalFile > 0">
          <thead>
          <tr>
            <th>Type</th>
            <th>No of files</th>
            <th>Size</th>
          </tr>
          </thead>
          <tbody>
          <tr v-if="fileType.jpg">
            <td>{{ fileType.jpg }}</td>
            <td>{{ totalFileType.jpg }}</td>
            <td>{{ `${formatBytes(totalMimeType.jpg)}(${totalMimeType.jpg})B` }}</td>
          </tr>
          <tr v-if="fileType.png">
            <td>{{ fileType.png }}</td>
            <td>{{ totalFileType.png }}</td>
            <td>{{ `${formatBytes(totalMimeType.png)}(${totalMimeType.png})B` }}</td>
          </tr>
          </tbody>
        </table>
        <h1 v-else>No data</h1>
      </div>
    </div>
  </div>
</template>

<script>
import uploadService from '@/services/uploadService'

export default {
  name: "Dashboard",
  data: () => {
    return {
      totalSize: 0,
      totalFile: 0,
      fileType: [],
      totalFileType: {},
      totalMimeType: {},
      authenticated: localStorage.getItem('status'),
      userId: localStorage.getItem('user')
    }
  },
  methods: {
    formatBytes(bytes, decimals = 2) {
      if (bytes == 0) return '0.00 MB';
      const kb = 1024;
      const dm = decimals < 0 ? 0 : decimals;
      const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

      const i = Math.floor(Math.log(bytes) / Math.log(kb));
      return parseFloat((bytes / Math.pow(kb, i)).toFixed(dm)) + ' ' + sizes[i];
    }
  },
  async mounted() {
    await uploadService.information(this.userId).then((response) => {
      const fileUpload = response.data.file_upload
      this.fileType = fileUpload.file_type
      this.totalSize = fileUpload.total_size ?? 0
      this.totalFile = fileUpload.total_file ?? 0
      this.totalFileType = fileUpload.total_file_type
      this.totalMimeType = fileUpload.total_mime_type
      console.log(this.totalSize)
    })
  }
}
</script>

<style scoped>
#dashboard {
  background-color: #FFFFFF;
  border: 1px solid #CCCCCC;
  padding: 20px;
  margin-top: 10px;
}
</style>