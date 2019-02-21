<template>
  <vueDropzone
    ref="myVueDropzone"
    @vdropzone-success="filesAdded"
    @vdropzone-removed-file="fileRemoved"
    @vdropzone-max-files-exceeded="fileExceeded"
    id="dropzone"
    v-model="attachment_receipt"
    :options="dropzoneOptions"
  >
  </vueDropzone>
</template>

<script>
// import axios from 'axios'
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
  name: 'AttachmentImageUpload',
  components: {
    vueDropzone: vue2Dropzone
  },
  data () {
    return {
      attachment_receipt: [],
      dropzoneOptions: {
        url: '/admin/jobscards/addedfile',
        thumbnailWidth: 150,
        maxFilesize: 2,
        maxFiles: 9,
        addRemoveLinks: true,
        clickable: true,
        acceptedFiles: 'image/*',
        dictDefaultMessage: 'Drop Images here to upload.',
        headers: {
          'X-CSRF-TOKEN': document.head.querySelector('[name=csrf-token]')
            .content
        }
      }
    }
  },
  created: function () {},
  methods: {
    filesAdded (file, response) {
      if (file) {
        this.attachment_receipt.push(file)
        this.$emit('changeFile', this.attachment_receipt)
      }
    },
    fileRemoved (file) {
      if (this.isNew) {
        var workorderImg = this.attachment_receipt
        var IndexToRemove = workorderImg.indexOf(file)
        if (IndexToRemove !== -1) {
          this.attachment_receipt.splice(IndexToRemove, 1)
          this.$emit('changeFile', this.attachment_receipt)
        }
      }
    },
    fileExceeded (file) {
      // console.log(file)
    }
  }
}
</script>
