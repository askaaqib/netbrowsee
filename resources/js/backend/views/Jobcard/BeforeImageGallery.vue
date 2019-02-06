<template>
  <div>
    <gallery
      :images="beforepictures"
      :index="indexgallery"
      @close="indexgallery = null"
    ></gallery>
    <template v-for="(image, imageInd) in modelbeforepictures">
      <div
        v-if="image.image_name"
        class="image workorder-img"
        :key="imageInd"
        @click="indexgallery = imageInd"
        :style="{
          backgroundImage: 'url(' + image.image_name + ')',
          width: '130px',
          height: '80px',
          backgroundSize: 'cover'
        }"
      >
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
      </div>
    </template>
  </div>
</template>

<script>
import axios from 'axios'
import VueGallery from 'vue-gallery'

export default {
  name: 'BeforeImageGallery',
  components: {
    gallery: VueGallery
  },
  props: {
    beforepictures: {
      type: Array,
      default: () => []
    },
    modelbeforepictures: {
      type: Array,
      default: () => []
    },
    id: {
      type: String,
      default: null
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
        var workorderImg = this.modelbeforepictures
        var imgname = workorderImg[index].image_name
        // console.log(workorderImg[index].image_name)
        this.modelbeforepictures.splice(index, 1)
        await axios
          .post(this.$app.route('admin.jobcards.removeimage'), {
            id: this.id,
            image_name: imgname,
            type: 'before_pictures'
          })
          .then((response) => {
            if (response.data.status === 200) {
              this.$emit('changeFile', this.modelbeforepictures)
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
