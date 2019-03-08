<template>
  <div>
    <form @submit.prevent="onSubmit">
      <b-row>
        <b-col xl="8">
          <b-card>
            <h3 class="card-title" slot="header">{{ isNew ? $t('labels.backend.district.titles.create') : $t('labels.backend.district.titles.edit') }}</h3>
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
            <b-dropdown right split :text="$t('buttons.jobcards.save_and_publish')" class="float-right"
                        variant="success" size="sm" @click="model.status = 'publish'; onSubmit()"
                        :disabled="pending"
                        v-if="isNew || this.$app.user.can('edit district') || this.$app.user.can('edit own projects')"
            >
              <b-dropdown-item @click="model.status = 'draft'; onSubmit()">{{ $t('buttons.jobcards.save_as_draft') }}
              </b-dropdown-item>
            </b-dropdown>
          </b-card>
        </b-col>
      </b-row>
    </form>
  </div>
</template>
<script>
// import axios from 'axios'
import form from '../../mixins/form'
export default {
  name: 'DistrictForm',
  mixins: [form],
  data () {
    return {
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: true
      },
      modelName: 'district',
      resourceRoute: 'districts',
      listPath: '/districts',
      tags: [],
      model: {
        name: null
      }
    }
  }
}
</script>
