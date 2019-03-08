<template>
  <div>
    <form @submit.prevent="onSubmit">
      <b-row>
        <b-col xl="8">
          <b-card>
            <h3 class="card-title" slot="header">{{ isNew ? $t('labels.backend.subdistrict.titles.create') : $t('labels.backend.subdistrict.titles.edit') }}</h3>
            <b-form-group
              :label="$t('validation.jobcards.district')"
              label-for="district"
              horizontal
              :label-cols="2"
              :feedback="feedback('district')"
            >
              <b-select v-model="model.district_id" :state="state('district_id')">
                <option value="">Please Select Districts</option>
                <option v-for="(option, index) in district" :key="index" :value="option.id">
                  {{ option.name }}
                </option>
              </b-select>
            </b-form-group>
            <b-form-group
              :label="$t('validation.attributes.name')"
              label-for="name"
              horizontal
              :label-cols="2"
              :feedback="feedback('name')"
            >
              <b-form-input
                id="name"
                name="name"
                required
                :placeholder="$t('validation.attributes.name')"
                v-model="model.name"
                :state="state('name')"
              ></b-form-input>
            </b-form-group>
            <b-dropdown
              right
              split
              :text="$t('buttons.jobcards.save_and_publish')"
              class="float-right"
              variant="success"
              size="sm"
              @click="model.status = 'publish'; onSubmit()"
              :disabled="pending"
              v-if="isNew || this.$app.user.can('edit district') || this.$app.user.can('edit own projects')"
            >
              <b-dropdown-item
                @click="model.status = 'draft'; onSubmit()"
              >
                {{ $t('buttons.jobcards.save_as_draft') }}
              </b-dropdown-item>
            </b-dropdown>
          </b-card>
        </b-col>
      </b-row>
    </form>
  </div>
</template>
<script>
import axios from 'axios'
import form from '../../mixins/form'
export default {
  name: 'SubDistrictForm',
  mixins: [form],
  data () {
    return {
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: true
      },
      modelName: 'subdistrict',
      resourceRoute: 'subdistricts',
      listPath: '/subdistricts',
      tags: [],
      district: [],
      model: {
        name: null,
        district_id: ''
      }
    }
  },
  created: function () {
    this.getdistrict()
  },
  methods: {
    async getdistrict () {
      let { data } = await axios.get(this.$app.route('admin.district.getdata'), {})
      this.district = data
    }
  }
}
</script>
