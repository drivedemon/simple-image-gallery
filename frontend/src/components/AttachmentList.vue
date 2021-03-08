<template>
  <div class="container">
    <ul class="container-content" v-if="images.length > 0 || tempAttachments.length > 0">
      <li class="item" v-for="tempAttachment in tempAttachments.slice().reverse()" :key="tempAttachment._id">
        <div class="image-container">
          <h1 v-if="checkProgress(tempAttachment)" class="upload-progress text-center">
            {{ `${tempAttachment.progress} %` }}
          </h1>
          <img v-if="checkFilePath(tempAttachment.filePath)" class="image w-100" style="height: 200px;" :src="tempAttachment.filePath">
          <div v-if="!checkFilePath(tempAttachment.filePath)" class="text-center image">
            <i v-if="!checkProgress(tempAttachment) && tempAttachment.fileResponse" class="fa fa-exclamation-triangle fa-lg mb-2 upload-progress text-center" style="color:#B22222;" aria-hidden="true"></i>
            <p class="text-danger">{{ fileValidation(tempAttachment.fileResponse) }}</p>
          </div>
          <div v-if="tempAttachment.fileResponse" class="middle">
            <b-button v-if="checkFilePath(tempAttachment.filePath)" class="btn btn-sm btn-primary mr-1" @click="$bvModal.show(tempAttachment.fileResponse.id)">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search"
                   viewBox="0 0 16 16">
                <path
                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
              </svg>
            </b-button>
            <button class="btn btn-sm btn-danger" v-on:click="removeImage(tempAttachment.fileResponse.id)">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash"
                   viewBox="0 0 16 16">
                <path
                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd"
                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
              </svg>
            </button>
          </div>
          <b-modal v-if="checkFilePath(tempAttachment.filePath)" :id="tempAttachment.fileResponse.id" no-close-on-esc hide-footer>
            <img :src="tempAttachment.filePath">
          </b-modal>
        </div>
      </li>

      <li class="item" v-for="image in images" :key="image.id">
        <div class="image-container">
          <img v-if="checkFilePath(image.file_path)" class="image w-100" style="height: 200px;" :src="image.file_path">
          <div v-else class="text-center image">
            <i class="fa fa-exclamation-triangle fa-lg mb-2 upload-progress text-center" style="color:#B22222;" aria-hidden="true"></i>
            <p class="text-danger">{{ `${fileValidation(image)} - ${image.file_name}` }}</p>
          </div>
          <div class="middle">
            <b-button v-if="checkFilePath(image.file_path)" class="btn btn-sm btn-primary mr-1" id="show-btn" @click="$bvModal.show(image.id)">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search"
                   viewBox="0 0 16 16">
                <path
                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
              </svg>
            </b-button>
            <button class="btn btn-sm btn-danger" v-on:click="removeImage(image.id)">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash"
                   viewBox="0 0 16 16">
                <path
                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd"
                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
              </svg>
            </button>
          </div>
        </div>
        <b-modal :id="image.id" hide-header hide-footer>
          <img :src="image.file_path">
        </b-modal>
      </li>
    </ul>
  </div>
</template>

<script>
import uploadService from "@/services/uploadService";

export default {
  name: "AttachmentList",
  components: {},
  data() {
    return {
      allowedType: ['png', 'jpg'],
      allowedSize: 10485760,
      userId: localStorage.getItem('user'),
      images: [],
      modalShow: false,
      isSuccess: false,
    }
  },
  created() {
    this.fetchImages();
  },
  methods: {
    fileValidation(image) {
      if (image === null) return
      if (!this.allowedType.includes(image.file_extension)) return `File type not support - ${image.file_name}`
      if (this.allowedSize < image.file_size) return `File size exceeded - ${image.file_name}`
    },
    checkFilePath(filePath) {
      return filePath !== null
    },
    checkProgress(attachment) {
      if (attachment.progress === "100") this.isSuccess = true
      return attachment.progress !== "100"
    },
    async removeImage(imageId) {
      await uploadService.delete(imageId)
          .then(() => {
            window.location.reload()
          })
          .catch(e => {
            console.log('errors', e)
          })
    },
    async fetchImages() {
      await uploadService.fetch(this.userId)
          .then(response => {
            this.images = response.data.file_upload
          })
          .catch(e => {
            console.log('errors', e)
          })
    },
  },
  props: {
    tempAttachments: {
      type: Array
    },
    attachments: {
      type: Array
    }
  }
};
</script>

<style>
li {
  border: 1px solid;
  margin-bottom: 8px;
  border-radius: 8px;
  margin-right: 8px;
  padding: 0 10px;
  align-items: center;
  justify-content: center;
}

.image {
  opacity: 1;
  border-radius: 8px;
  display: block;
  width: 100%;
  height: auto;
  transition: .5s ease;
  backface-visibility: hidden;
}

.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}

.image-container:hover .image {
  opacity: 0.3;
}

.image-container:hover .middle {
  opacity: 1;
}

.modal-backdrop {
  z-index: 0 !important;
}

.upload-progress {
  margin-top: 20%;
  font-size: 16px;
}
</style>
