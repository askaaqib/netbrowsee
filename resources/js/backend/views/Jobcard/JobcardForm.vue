<template>
  <div>
    <form @submit.prevent="onSubmit">
      <b-row>
        <b-col xl="8">
          <b-card>
            <h3 class="card-title" slot="header">{{ isNew ? $t('labels.backend.jobcards.titles.create') : $t('labels.backend.jobcards.titles.edit') }}</h3>
            <b-form-group
              :label="$t('validation.jobcards.jobcard_num')"
              label-for="jobcard_num"
              horizontal
              :label-cols="2"
              :feedback="feedback('jobcard_num')"
            >
              <b-form-input
                id="jobcard_num"
                name="jobcard_num"
                required
                :placeholder="$t('validation.jobcards.jobcard_num')"
                v-model="model.jobcard_num"
                :state="state('jobcard_num')"
              ></b-form-input>
            </b-form-group>
            <b-form-group
              :label="$t('validation.jobcards.description')"
              label-for="description"
              horizontal
              :label-cols="2"
              :feedback="feedback('description')"
            >
              <b-form-textarea
                id="description"
                name="description"
                :required="model.contractor_id != '' ? true : false"
                :rows="5"
                :placeholder="$t('validation.jobcards.description')"
                v-model="model.description"
                :state="state('description')"
              ></b-form-textarea>
            </b-form-group>
            <b-form-group
              :label="$t('validation.jobcards.problem_type')"
              label-for="problem_type"
              horizontal
              :label-cols="2"
              :feedback="feedback('problem_type')"
            >
              <b-form-input
                id="problem_type"
                name="problem_type"
                :required="model.contractor_id != '' ? true : false"
                :placeholder="$t('validation.jobcards.problem_type')"
                v-model="model.problem_type"
                :state="state('problem_type')"
              ></b-form-input>
            </b-form-group>
            <b-form-group
              :label="$t('validation.jobcards.priority')"
              label-for="priority"
              horizontal
              :label-cols="2"
              :feedback="feedback('priority')"
            >
              <b-form-input
                id="priority"
                name="priority"
                :required="model.contractor_id != '' ? true : false"
                :placeholder="$t('validation.jobcards.priority')"
                v-model="model.priority"
                :state="state('priority')"
              ></b-form-input>
            </b-form-group>
            <b-form-group
              :label="$t('validation.jobcards.facility_name')"
              label-for="facility_name"
              horizontal
              :label-cols="2"
              :feedback="feedback('facility_name')"
            >
              <b-form-input
                id="facility_name"
                name="facility_name"
                :required="model.contractor_id != '' ? true : false"
                :placeholder="$t('validation.jobcards.facility_name')"
                v-model="model.facility_name"
                :state="state('facility_name')"
              ></b-form-input>
            </b-form-group>
            <template v-if="district.length > 0">
              <b-form-group
                :label="$t('validation.jobcards.district')"
                label-for="district"
                horizontal
                :label-cols="2"
                :feedback="feedback('district')"
              >
                <b-select
                  v-model="model.district"
                  :state="state('district')"
                >
                  <option value="">Please Select Districts</option>
                  <option
                    v-for="(option, index) in district"
                    :key="index"
                    :value="option.id"
                  >
                    {{ option.name }}
                  </option>
                </b-select>
              </b-form-group>
            </template>
            <template v-if="district.length > 0 && subdistrict.length > 0">
              <b-form-group
                :label="$t('validation.jobcards.sub_district')"
                label-for="SubDistrict"
                horizontal
                :label-cols="2"
                :feedback="feedback('SubDistrict')"
              >
                <b-select
                  v-model="model.sub_district"
                  :state="state('subdistrict_id')"
                >
                  <option value="">Please Select SubDistricts</option>
                  <option
                    v-for="(option, index) in subdistrict"
                    :key="index"
                    :value="option.id"
                  >
                    {{ option.name }}
                  </option>
                </b-select>
              </b-form-group>
            </template>
            <b-form-group
              :label="$t('validation.jobcards.projects')"
              label-for="projects"
              horizontal
              :label-cols="2"
              :feedback="feedback('projects_id')"
            >
              <b-select
                v-model="model.projects_id"
                :state="state('projects_id')"
              >
                <option value="">Please Select Projects</option>
                <option
                  v-for="(option, index) in projects"
                  :key="index"
                  :value="option.id"
                >
                  {{ option.name }}
                </option>
              </b-select>
            </b-form-group>
            <b-form-group
              :label="$t('validation.jobcards.projectmanager')"
              label-for="projectmanager"
              horizontal
              :label-cols="2"
              :feedback="feedback('projectmanager_id')"
            >
              <b-select
                v-model="model.projectmanager_id"
                :state="state('projectmanager_id')"
              >
                <option value="">Please Select Project Manager</option>
                <option
                  v-for="(option, index) in project_manager"
                  :key="index"
                  :value="option.id"
                >
                  {{ option.name }}
                </option>
              </b-select>
            </b-form-group>
            <b-form-group
              :label="$t('validation.jobcards.labour_paid')"
              label-for="labour_paid"
              horizontal
              :label-cols="2"
              :feedback="feedback('labour_paid')"
            >
              <b-form-input
                id="labour_paid"
                name="labour_paid"
                :placeholder="$t('validation.jobcards.labour_paid')"
                v-model="model.labour_paid"
                :state="state('labour_paid')"
              ></b-form-input>
            </b-form-group>
            <b-form-group
              :label="$t('validation.jobcards.travelling_paid')"
              label-for="travelling_paid"
              horizontal
              :label-cols="2"
              :feedback="feedback('travelling_paid')"
            >
              <b-form-input
                id="travelling_paid"
                name="travelling_paid"
                :placeholder="$t('validation.jobcards.travelling_paid')"
                v-model="model.travelling_paid"
                :state="state('travelling_paid')"
              ></b-form-input>
            </b-form-group>
            <b-form-group
              :label="$t('validation.jobcards.materials_paid')"
              label-for="materials_rates_id"
              horizontal
              :label-cols="2"
              :feedback="feedback('materials_rates_id')"
            >
              <b-form-input
                id="materials_paid"
                name="materials_paid"
                :placeholder="$t('validation.jobcards.materials_paid')"
                v-model="model.materials_paid"
                :state="state('materials_paid')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.status')"
              label-for="status"
              horizontal
              :label-cols="2"
              :feedback="feedback('status')"
            >
              <b-select
                v-model="model.status"
              >
                <option value="null">Please Select Status</option>
                <option value="1" data-foo="Received">Received</option>
                <option value="2" data-foo="Assigned">Assigned</option>
                <option value="3" data-foo="On Hold">On Hold</option>
                <option value="4" data-foo="Completed">Completed</option>
                <option value="5" data-foo="Submitted for Vetting">Submitted for Vetting</option>
                <option value="6" data-foo="Invoiced">Invoiced</option>
                <option value="7" data-foo="Paid">Paid</option>
                <option value="8" data-foo="Cancelled">Cancelled</option>
              </b-select>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.assigned_to')"
              label-for="contractor_id"
              horizontal
              :label-cols="2"
              :feedback="feedback('contractor_id')"
            >
              <b-select v-model="model.contractor_id" :state="state('contractor_id')">
                <option value="">Please Select User to assign</option>
                <option v-for="(option, index) in assigned_to" :key="index" :value="option.id">
                  {{ option.name }}
                </option>
              </b-select>
            </b-form-group>

            <b-form-group
              label="Vat Rate"
              label-for="vat_rate"
              horizontal
              :label-cols="2"
              :feedback="feedback('vat_rate')"
            >
              <b-form-input
                v-model="model.vat_rate"
                :state="state('vat_rate')"
              ></b-form-input>
            </b-form-group>

            <!-- BEFORE PICTURES -->
            <b-form-group
              :label="$t('validation.jobcards.before_pictures')"
              label-for="before_pictures"
              horizontal
              :label-cols="2"
              :feedback="feedback('before_pictures')"
            >
            </b-form-group>
            <template v-if="isNew">
              <BeforeImageUpload @changeFile="beforeImagesAdded"></BeforeImageUpload>
            </template>

            <template v-if="!isNew">
              <b-row>
                <BeforeImageGallery
                  :id="id"
                  :jobcard-pic-size="true"
                  :beforepictures="beforepictures"
                  :modelbeforepictures="model.before_pictures"
                  @changeFile="changeBeforeGalleryImage"
                ></BeforeImageGallery>
              </b-row>
              <b-row>
                <BeforeImageEdit @changeFile="beforeImagesEdit"></BeforeImageEdit>
              </b-row>
            </template>

            <!-- AFTER PICTURES -->
            <b-form-group
              :label="$t('validation.jobcards.after_pictures')"
              label-for="after_pictures"
              horizontal
              :label-cols="2"
              :feedback="feedback('after_pictures')"
            >
            </b-form-group>
            <template v-if="isNew">
              <AfterImageUpload @changeFile="afterImagesAdded"></AfterImageUpload>
            </template>

            <template v-if="!isNew">
              <b-row>
                <AfterImageGallery
                  :id="id"
                  :jobcard-pic-size="true"
                  :afterpictures="afterpictures"
                  :modelafterpictures="model.after_pictures"
                  @changeFile="changeAfterGalleryImage"
                ></AfterImageGallery>
              </b-row>
              <b-row>
                <AfterImageEdit @changeFile="afterImagesEdit"></AfterImageEdit>
              </b-row>
            </template>
            <!-- Any receipts and invoices Attachment -->
            <b-form-group
              :label="$t('validation.jobcards.attachment_receipt')"
              label-for="attachment_receipt"
              horizontal
              :label-cols="4"
              :feedback="feedback('attachment_receipt')"
            >
            </b-form-group>
            <template v-if="isNew">
              <AttachmentImageUpload @changeFile="attachmentImagesAdded"></AttachmentImageUpload>
            </template>

            <template v-if="!isNew">
              <b-row>
                <AttachmentImageGallery
                  :id="id"
                  :jobcard-pic-size="true"
                  :image-width="'130px'"
                  :image-height="'80px'"
                  :attachmentpictures="attachmentpictures"
                  :modelattachmentpictures="model.attachment_receipt"
                  @changeFile="changeAttachmentGalleryImage"
                ></AttachmentImageGallery>
              </b-row>
              <b-row>
                <AttachmentImageEdit @changeFile="attachmentImagesEdit"></AttachmentImageEdit>
              </b-row>
            </template>

            <b-row slot="footer">
              <b-col md>
                <b-button to="/jobcards" exact variant="danger" size="md">
                  {{ $t('buttons.back') }}
                </b-button>
              </b-col>
              <b-col md>
                <input name="status" type="hidden" value="publish">
                <!-- <button
                  class="float-right"
                  variant="success"
                  size="sm"
                  @click= "onSubmit()"
                >
                  Submit
                </button> -->
                <div class="confirm-upload">
                  <b-button :disabled="pending" @click="onSubmit()" class="btn-green">Confirm</b-button>
                </div>
              </b-col>
            </b-row>
          </b-card>
        </b-col>
      </b-row>
    </form>
  </div>
</template>
<script>
import axios from 'axios'
import form from '../../mixins/form'
import AfterImageUpload from './AfterImagesUpload'
import AfterImageEdit from './AfterImagesEdit'
import AfterImageGallery from './AfterImageGallery'
import BeforeImageUpload from './BeforeImagesUpload'
import BeforeImageEdit from './BeforeImagesEdit'
import BeforeImageGallery from './BeforeImageGallery'
import AttachmentImageUpload from './AttachmentImagesUpload'
import AttachmentImageEdit from './AttachmentImagesEdit'
import AttachmentImageGallery from './AttachmentImageGallery'

export default {
  name: 'JobcardForm',
  components: {
    AfterImageUpload,
    AfterImageGallery,
    AfterImageEdit,
    BeforeImageUpload,
    BeforeImageGallery,
    BeforeImageEdit,
    AttachmentImageUpload,
    AttachmentImageEdit,
    AttachmentImageGallery

  },
  mixins: [form],
  data () {
    return {
      modelName: 'jobcard',
      resourceRoute: 'jobcards',
      listPath: '/jobcards',
      indexgallery: null,
      beforepictures: [],
      afterpictures: [],
      attachmentpictures: [],
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: true
      },
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
      },
      labour_rates: [],
      projects: [],
      project_manager: [],
      materials_rates: [],
      assigned_to: [],
      quotations: [],
      district: [],
      subdistrict: [],
      jsonParseImgBefore: false,
      jsonParseImgAfter: false,
      jsonParseImgAttach: false,
      model: {
        jobcard_num: null,
        description: null,
        problem_type: null,
        priority: null,
        facility_name: null,
        district: null,
        sub_district: null,
        // subdistrict,
        labour_paid: null,
        materials_paid: null,
        projects_id: '',
        projectmanager_id: '',
        travelling_paid: null,
        contractor_id: '',
        status: null,
        vat_rate: null,
        before_pictures: [],
        before_pictures_edit: [],
        after_pictures: [],
        attachment_receipt: [],
        after_pictures_edit: [],
        attachment_receipt_edit: []
      }
    }
  },
  watch: {
    'model.before_pictures': function (val) {
      if (val && val.length > 0) {
        if (!this.isNew && !this.jsonParseImgBefore) {
          this.jsonParseImgBefore = true
          this.model.before_pictures = JSON.parse(val)
          var Workordrimg = JSON.parse(val)
          Workordrimg.map((item) => {
            if (item.image_name) {
              this.beforepictures.push(item.image_name)
            }
          })
        }
      }
    },
    'model.after_pictures': function (val) {
      if (val && val.length > 0) {
        if (!this.isNew && !this.jsonParseImgAfter) {
          this.jsonParseImgAfter = true
          this.model.after_pictures = JSON.parse(val)
          var Workordrimg = JSON.parse(val)
          Workordrimg.map((item) => {
            if (item.image_name) {
              this.afterpictures.push(item.image_name)
            }
          })
        }
      }
    },
    'model.attachment_receipt': function (val) {
      // console.log(val);
      if (val && val.length > 0) {
        if (!this.isNew && !this.jsonParseImgAttach) {
          this.jsonParseImgAttach = true
          this.model.attachment_receipt = JSON.parse(val)
          // console.log(this.model.attachment_receipt);
          var Workordrimg = JSON.parse(val)
          Workordrimg.map((item) => {
            // console.log(item);
            if (item.image_name) {
              this.attachmentpictures.push(item.image_name)
            }
          })
        }
      }
    }
  },
  created: function () {
    this.getLabours()
    this.getMaterials()
    this.getProjects()
    this.getProjectManager()
    this.getUsers()
    this.getQuotations()
    this.getdistrict()
    this.getsubdistrict()
  },
  methods: {
    changeBeforeGalleryImage (images) {
      this.model.before_pictures = images
    },
    changeAfterGalleryImage (images) {
      this.model.after_pictures = images
    },
    changeAttachmentGalleryImage (images) {
      this.model.attachment_receipt = images
    },
    afterImagesEdit (images) {
      this.model.after_pictures_edit = images
    },
    attachmentImagesEdit (images) {
      this.model.attachment_receipt_edit = images
    },
    beforeImagesEdit (images) {
      this.model.before_pictures_edit = images
    },
    afterImagesAdded (images) {
      this.model.after_pictures = images
    },
    attachmentImagesAdded (images) {
      this.model.attachment_receipt = images
    },
    beforeImagesAdded (images) {
      this.model.before_pictures = images
    },
    filesAdded (store, response) {
      if (store) {
        this.model.before_pictures.push(store)
      }
    },
    filesAddeds (store, response) {
      if (store) {
        this.model.after_pictures.push(store)
      }
    },
    filesAddedes (store, response) {
      if (store) {
        this.model.attachment_receipt.push(store)
      }
    },
    fileRemoved (store) {
      if (this.isNew) {
        var workorderImg = this.model.before_pictures
        var IndexToRemove = workorderImg.indexOf(store)
        if (IndexToRemove !== -1) {
          this.model.before_pictures.splice(IndexToRemove, 1)
        }
      }
    },
    fileRemovede (store) {
      if (this.isNew) {
        var workorderImg = this.model.attachment_receipt
        var IndexToRemove = workorderImg.indexOf(store)
        if (IndexToRemove !== -1) {
          this.model.attachment_receipt.splice(IndexToRemove, 1)
        }
      }
    },
    fileRemoveds (store) {
      if (this.isNew) {
        var workorderImg = this.model.after_pictures
        var IndexToRemove = workorderImg.indexOf(store)
        if (IndexToRemove !== -1) {
          this.model.after_pictures.splice(IndexToRemove, 1)
        }
      }
    },
    async confirmUpload () {
      var model = this.model
      let action = ''
      if (this.isNew) {
        action = this.$app.route(`admin.jobcards.store`)
      } else {
        action = this.$app.route(`admin.jobcards.update`, { [this.modelName]: this.id })
      }
      let formData = this.$app.objectToFormData(model)
      if (!this.isNew) {
        formData.append('_method', 'PATCH')
      }
      // formData.append('_method', 'PATCH')
      await axios.post(action, formData)
        .then((response) => {
          if (response.data.status === 'success') {
            this.$app.noty[response.data.status](response.data.message)
            this.$router.push('/jobcards')
          } else {
            this.$app.noty[response.data.status](response.message)
          }
        })
    },
    async getLabours () {
      let { data } = await axios.get(this.$app.route('admin.labours.getdata'), {})
      this.labour_rates = data
    },
    async getMaterials () {
      let { data } = await axios.get(this.$app.route('admin.materials.getdata'), {})
      this.materials_rates = data
    },
    async getProjects () {
      let { data } = await axios.get(this.$app.route('admin.projects.getdata'), {})
      this.projects = data
    },
    async getProjectManager () {
      let { data } = await axios.get(this.$app.route('admin.project_manager.getdata'), {})
      this.project_manager = data
    },
    async getdistrict () {
      let { data } = await axios.get(this.$app.route('admin.district.getdata'), {})
      this.district = data
    },
    async getsubdistrict () {
      let { data } = await axios.get(this.$app.route('admin.subdistrict.getdata'), {})
      this.subdistrict = data
    },
    async getUsers () {
      let { data } = await axios.get(this.$app.route('admin.users.getdata'), {})
      this.assigned_to = data
    },
    async getQuotations () {
      let { data } = await axios.get(this.$app.route('admin.quotations.getdata'), {})
      this.quotations = data
    }
  }
}
</script>
