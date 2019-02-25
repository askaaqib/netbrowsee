<template>
  <div>
    <gallery
      :images="afterpictures"
      :index="indexgallery"
      @close="indexgallery = null"
    ></gallery>
    <template v-for="(image, imageInd) in modelafterpictures">
      <div
        v-if="image.image_name"
        class="image workorder-img"
        :key="imageInd"
        @click="indexgallery = imageInd"
        :style="{
          backgroundImage: 'url(' + image.image_name + ')',
          width: imageWidth,
          height: imageHeight,
          backgroundSize: 'cover'
        }"
      >
        <template v-if="jobcardPicSize">
          <div class="edit">
            <b-button
              variant="danger"
              @click.stop="
                indexgallery = null
                deleteWorkOrderImg(imageInd)
              "
            >
              <i class="fe fe-trash fe-lg"></i>
            </b-button>
          </div>
        </template>
      </div>
    </template>
  </div>
</template>

<script>
import axios from 'axios'
import VueGallery from 'vue-gallery'

export default {
  name: 'AfterImageGallery',
  components: {
    gallery: VueGallery
  },
  props: {
    afterpictures: {
      type: Array,
      default: () => []
    },
    modelafterpictures: {
      type: Array,
      default: () => []
    },
    jobcardPicSize: {
      type: Boolean,
      default: false
    },
    id: {
      type: String,
      default: null
    },
    imageHeight: {
      type: String,
      default: '100px'
    },
    imageWidth: {
      type: String,
      default: '100px'
    }
  },
  data () {
    return {
      indexgallery: null
    }
  },
  created: function () {},
  methods: {
    async deleteWorkOrderImg (index) {
      var confirm1 = confirm(
        'Are you sure you want to delete this image? \n This action cannot be reversed.'
      )
      if (confirm1) {
        var workorderImg = this.modelafterpictures
        var imgname = workorderImg[index].image_name
        // console.log(workorderImg[index].image_name)
        this.modelafterpictures.splice(index, 1)
        await axios
          .post(this.$app.route('admin.jobcards.removeimage'), {
            id: this.id,
            image_name: imgname,
            type: 'after_pictures'
          })
          .then((response) => {
            if (response.data.status === 200) {
              this.$emit('changeFile', this.modelafterpictures)
            }
          })
      }
    }
  }
}
</script>

<style scoped>
  .image {
    float: left;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    border: 1px solid #ebebeb;
    margin: 5px;
  }
</style>
