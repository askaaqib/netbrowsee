<template>
  <vue-dropzone
    ref="myVueDropzone"
    @vdropzone-success="filesAddedEdit"
    @vdropzone-removed-file="fileRemovedEdit"
    id="dropzone"
    v-model="after_pictures_edit"
    :options="dropzoneOptionsEdit"
  >
  </vue-dropzone>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
  name: 'AfterImagesEdit',
  components: {
    vueDropzone: vue2Dropzone
  },
  data () {
    return {
      after_pictures_edit: [],
      dropzoneOptionsEdit: {
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
    filesAddedEdit (file, response) {
      if (file) {
        this.after_pictures_edit.push(file)
        this.$emit('changeFile', this.after_pictures_edit)
      }
    },
    fileRemovedEdit (file) {
      var workorderImg = this.after_pictures_edit
      var IndexToRemove = workorderImg.indexOf(file)
      if (IndexToRemove !== -1) {
        this.after_pictures_edit.splice(IndexToRemove, 1)
        this.$emit('changeFile', this.after_pictures_edit)
      }
    },
    fileExceeded (file) {
      // console.log(file)
    }
  }
}
</script>
