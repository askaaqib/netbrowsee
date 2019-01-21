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

            <b-form-group
              :label="$t('validation.jobcards.district')"
              label-for="district"
              horizontal
              :label-cols="2"
              :feedback="feedback('district')"
            >
              <b-form-input
                id="district"
                name="district"
                :required="model.contractor_id != '' ? true : false"
                :placeholder="$t('validation.jobcards.district')"
                v-model="model.district"
                :state="state('district')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.sub_district')"
              label-for="sub_district"
              horizontal
              :label-cols="2"
              :feedback="feedback('sub_district')"
            >
              <b-form-input
                id="sub_district"
                name="sub_district"
                :required="model.contractor_id != '' ? true : false"
                :placeholder="$t('validation.jobcards.sub_district')"
                v-model="model.sub_district"
                :state="state('sub_district')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.projects')"
              label-for="projects"
              horizontal
              :label-cols="2"
              :feedback="feedback('projects_id')"
            >
              <b-select v-model="model.projects_id" :state="state('projects_id')">
                <option value="">Please Select Projects</option>
                <option v-for="(option, index) in projects" :key="index" :value="option.id">
                  {{ option.name }}
                </option>
              </b-select>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.labour_paid')"
              label-for="labour_rates_id"
              horizontal
              :label-cols="2"
              :feedback="feedback('labour_rates_id')"
            >
              <b-select v-model="model.labour_rates_id" :state="state('labour_rates_id')">
                <option value="">Please Select Labour Rates</option>
                <option v-for="(option, index) in labour_rates" :key="index" :value="option.id">
                  {{ option.name }}
                </option>
              </b-select>
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
                :required="model.contractor_id != '' ? true : false"
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
              <b-select v-model="model.materials_rates_id" :state="state('materials_rates_id')">
                <option value="">Please Select Labour Rates</option>
                <option v-for="(option, index) in materials_rates" :key="index" :value="option.id">
                  {{ option.name }}
                </option>
              </b-select>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.quoted_amount')"
              label-for="quoted_amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('quoted_amount')"
            >
              <b-form-input
                id="quoted_amount"
                name="quoted_amount"
                :required="model.contractor_id != '' ? true : false"
                :placeholder="$t('validation.jobcards.quoted_amount')"
                v-model="model.quoted_amount"
                :state="state('quoted_amount')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.status')"
              label-for="status"
              horizontal
              :label-cols="2"
              :feedback="feedback('status')"
            >
              <b-form-input
                id="status"
                name="status"
                :required="model.contractor_id != '' ? true : false"
                :placeholder="$t('validation.jobcards.status')"
                v-model="model.status"
                :state="state('status')"
              ></b-form-input>
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
              :label="$t('validation.jobcards.before_pictures')"
              label-for="before_pictures"
              horizontal
              :label-cols="2"
              :feedback="feedback('before_pictures')"
            >
              <b-form-input
                id="before_pictures"
                name="before_pictures"
                :required="model.contractor_id != '' ? true : false"
                :placeholder="$t('validation.jobcards.before_pictures')"
                v-model="model.before_pictures"
                :state="state('before_pictures')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.during_pictures')"
              label-for="during_pictures"
              horizontal
              :label-cols="2"
              :feedback="feedback('during_pictures')"
            >
              <b-form-input
                id="during_pictures"
                name="during_pictures"
                :required="model.contractor_id != '' ? true : false"
                :placeholder="$t('validation.jobcards.during_pictures')"
                v-model="model.during_pictures"
                :state="state('during_pictures')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.after_pictures')"
              label-for="after_pictures"
              horizontal
              :label-cols="2"
              :feedback="feedback('after_pictures')"
            >
              <b-form-input
                id="after_pictures"
                name="after_pictures"
                :required="model.contractor_id != '' ? true : false"
                :placeholder="$t('validation.jobcards.after_pictures')"
                v-model="model.after_pictures"
                :state="state('after_pictures')"
              ></b-form-input>
            </b-form-group>

            <b-row slot="footer">
              <b-col md>
                <b-button to="/jobcards" exact variant="danger" size="md">
                  {{ $t('buttons.back') }}
                </b-button>
              </b-col>
              <b-col md>
                <input name="status" type="hidden" value="publish">

                <b-dropdown right split :text="$t('buttons.jobcards.save_and_publish')" class="float-right"
                            variant="success" size="sm" @click="model.status = 'publish'; onSubmit()"
                            :disabled="pending"
                            v-if="isNew || this.$app.user.can('edit jobcards') || this.$app.user.can('edit own jobcards')"
                >
                  <b-dropdown-item @click="model.status = 'draft'; onSubmit()">{{ $t('buttons.jobcards.save_as_draft') }}
                  </b-dropdown-item>
                </b-dropdown>
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
import form from '../mixins/form'

export default {
  name: 'JobcardForm',
  mixins: [form],
  data () {
    return {
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: true
      },
      modelName: 'jobcard',
      resourceRoute: 'jobcards',
      listPath: '/jobcards',
      labour_rates: [],
      projects: [],
      materials_rates: [],
      assigned_to: [],
      quotations: [],
      model: {
        jobcard_num: null,
        description: null,
        problem_type: null,
        priority: null,
        facility_name: null,
        district: null,
        sub_district: null,
        projects_id: '',
        labour_rates_id: '',
        travelling_paid: null,
        materials_rates_id: '',
        contractor_id: '',
        quoted_amount: null,
        status: null,
        before_pictures: null,
        during_pictures: null,
        after_pictures: null
      }
    }
  },
  created: function () {
    this.getLabours()
    this.getMaterials()
    this.getProjects()
    this.getUsers()
    this.getQuotations()
  },
  methods: {
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
