<template>
  <div>
    <form @submit.prevent="onSubmit">
      <b-row>
        <b-col xl="8">
          <b-card>
            <h3 class="card-title" slot="header">{{ isNew ? $t('labels.backend.vat.titles.create') : $t('labels.backend.vat.titles.edit') }}</h3>
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

            <b-form-group
              :label="$t('validation.attributes.rate')"
              label-for="rate"
              horizontal
              :label-cols="2"
              :feedback="feedback('rate')"
            >
              <b-form-input
                id="rate"
                name="rate"
                required
                :placeholder="$t('validation.attributes.rate')"
                v-model="model.rate"
                :state="state('rate')"
              ></b-form-input>
            </b-form-group>

            <b-row slot="footer">
              <b-col md>
                <b-button to="/vat" exact variant="danger" size="md">
                  {{ $t('buttons.back') }}
                </b-button>
              </b-col>
              <b-col md>
                <b-dropdown right split :text="$t('buttons.vat.save_and_publish')" class="float-right"
                            variant="success" size="sm" @click="onSubmit()"
                            :disabled="pending"
                            v-if="isNew || this.$app.user.can('edit vat rates') || this.$app.user.can('edit own vat rates')"
                >
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
import form from '../mixins/form'

export default {
  name: 'VatForm',
  mixins: [form],
  data () {
    return {
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: true
      },
      modelName: 'vat',
      resourceRoute: 'vat',
      listPath: '/vat',
      model: {
        name: null,
        rate: null
      }
    }
  }
}
</script>
