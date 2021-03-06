<template>
  <div class="container">
    <ul class="container-content" v-if="tempAttachments.length > 0">
      <li class="item" v-for="tempAttachment in tempAttachments" :key="tempAttachment._id">
        <img class="w-100" style="height: 200px;" :src="tempAttachment.filePath">
<!--        <span class="uploaded-date"> {{ tempAttachment.size }} bytes </span>-->
<!--        <span v-if="checkProgress(tempAttachment)" class="upload-progress">-->
<!--          {{ `${tempAttachment.progress} %` }}-->
<!--        </span>-->
      </li>
    </ul>
  </div>
</template>

<script>
import API_URL from "@/services/api";

export default {
  name: "AttachmentList",
  components: {},
  data() {
    return {
      baseUrl: API_URL.BASE_URL,
      item: {
        image: 'https://picsum.photos/400/300'
      }
    };
  },
  methods: {
    checkProgress(attachment) {
      console.log(attachment.filePath)
      return attachment.progress !== null;
    }
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
}

.uploaded-date {
  font-size: 12px;
}

.upload-progress {
  font-size: 12px;
}

.file-info {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}
</style>
