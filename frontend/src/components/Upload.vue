<template>
  <div class="app">
    <vue-dropzone
        class="custom-border mb-3"
        id="upload"
        :options="config"
        v-on:vdropzone-file-added="fileAdded"
        v-on:vdropzone-upload-progress="uploadProgress"
        v-on:vdropzone-success="callbackSuccess"
        v-on:vdropzone-sending="sendingParams"
    >
    </vue-dropzone>
    <AttachmentList
        :tempAttachments="getTempAttachments"
        :attachments="getAttachments"
    />
  </div>
</template>

<script>
import API_URL from '@/services/api'
import vueDropzone from "vue2-dropzone"
import AttachmentList from "@/components/AttachmentList"
import uploadService from "@/services/uploadService";

export default {
  data: () => ({
    userId: localStorage.getItem('user'),
    tempAttachments: [],
    attachments: [],
    images: [],
    config: {
      url: API_URL.upload,
      previewsContainer: false,
      dictDefaultMessage: "<i class='fa fa-cloud-upload fa-lg'></i><br>Drop files here or click to choose files..."
    },
  }),
  components: {
    vueDropzone: vueDropzone,
    AttachmentList: AttachmentList,
  },
  computed: {
    getTempAttachments() {
      return this.tempAttachments;
    },
    getAttachments() {
      return this.attachments;
    },
  },
  methods: {
    fileAdded(file) {
      let attachment = {};
      attachment._id = file.upload.uuid;
      attachment.title = file.name;
      attachment.type = "file";
      attachment.extension = "." + file.type.split("/")[1];
      attachment.user = JSON.parse(localStorage.getItem("user"));
      attachment.thumb = file.dataURL;
      attachment.thumb_list = file.dataURL;
      attachment.isLoading = true;
      attachment.progress = 0;
      attachment.filePath = null;
      attachment.fileResponse = null;
      attachment.size = file.size;
      this.tempAttachments = [...this.tempAttachments, attachment];
    },
    sendingParams(file, xhr, formData) {
      formData.append('user_id', localStorage.getItem('user'));
    },
    uploadProgress(file, progress) {
      this.tempAttachments.map(attachment => {
        if (attachment.title === file.name) {
          attachment.progress = `${Math.floor(progress)}`;
        }
      });
    },
    callbackSuccess(file, response) {
      this.tempAttachments.map(attachment => {
        if (attachment.title === file.name) {
          attachment.fileResponse = response.file_upload
          if (response.file_upload.file_path) {
            attachment.filePath = `${API_URL.baseUrl}${response.file_upload.file_path}`
          }
        }
      });
    },
    async fetchImages() {
      await uploadService.fetch(this.userId)
          .then(response => {
            this.images = response.data.file_upload
          })
    },
  },
};
</script>

<style scoped>
.custom-border {
  border: #e5e5e5 3px dashed;
}
</style>
