<template>
  <vueDropzone
    ref="myVueDropzone"
    @vdropzone-success="filesAdded"
    @vdropzone-removed-file="fileRemoved"
    @vdropzone-max-files-exceeded="fileExceeded"
    id="dropzone"
    v-model="after_pictures"
    :options="dropzoneOptions"
  >
  </vueDropzone>
</template>

<script>
// import axios from 'axios'
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
  name: 'AfterImagesUpload',
  components: {
    vueDropzone: vue2Dropzone
  },
  data () {
    return {
      after_pictures: [],
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
        this.after_pictures.push(file)
        this.$emit('changeFile', this.after_pictures)
      }
    },
    fileRemoved (file) {
      if (this.isNew) {
        var workorderImg = this.after_pictures
        var IndexToRemove = workorderImg.indexOf(file)
        if (IndexToRemove !== -1) {
          this.after_pictures.splice(IndexToRemove, 1)
          this.$emit('changeFile', this.after_pictures)
        }
      }
    },
    fileExceeded (file) {
      // console.log(file)
    }
  }
}
</script>
