<template>
  <div>
    <form @submit.prevent="onSubmit">
      <b-row>
        <b-col xl="8">
          <b-card>
            <h3 class="card-title" slot="header">{{ isNew ? $t('labels.backend.settings.titles.create') : $t('labels.backend.settings.titles.edit') }}</h3>
            <b-form-group
              :label="$t('validation.settings.company_name')"
              label-for="company_name"
              horizontal
              :label-cols="2"
              :feedback="feedback('company_name')"
            >
              <b-form-input
                id="company_name"
                name="company_name"
                :placeholder="$t('validation.settings.company_name')"
                v-model="model.company_name"
                :state="state('company_name')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.settings.company_address')"
              label-for="company_address"
              horizontal
              :label-cols="2"
              :feedback="feedback('company_address')"
            >
              <b-form-textarea
                id="company_address"
                name="company_address"
                :placeholder="$t('validation.settings.company_address')"
                v-model="model.company_address"
                :state="state('company_address')"
              ></b-form-textarea>
            </b-form-group>

            <b-form-group
              :label="$t('validation.settings.bank_account')"
              label-for="bank_account"
              horizontal
              :label-cols="2"
              :feedback="feedback('bank_account')"
            >
              <b-form-input
                id="bank_account"
                name="bank_account"
                :placeholder="$t('validation.settings.bank_account')"
                v-model="model.bank_account"
                :state="state('bank_account')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.settings.quote_ref_start')"
              label-for="quote_ref_start"
              horizontal
              :label-cols="2"
              :feedback="feedback('quote_ref_start')"
            >
              <b-form-input
                id="quote_ref_start"
                name="quote_ref_start"
                :placeholder="$t('validation.settings.quote_ref_start')"
                v-model="model.quote_ref_start"
                :state="state('quote_ref_start')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.settings.quote_vat')"
              label-for="quote_vat"
              horizontal
              :label-cols="2"
              :feedback="feedback('quote_vat')"
            >
              <b-form-input
                id="quote_vat"
                name="quote_vat"
                :placeholder="$t('validation.settings.quote_vat')"
                v-model="model.quote_vat"
                :state="state('quote_vat')"
              ></b-form-input>
            </b-form-group>

            <b-form-group>
              <input type="file" @change="onFileSelected">
            </b-form-group>

            <b-row slot="footer">
              <b-col md>
                <b-button to="/settings" exact variant="danger" size="md">
                  {{ $t('buttons.back') }}
                </b-button>
              </b-col>
              <b-col md>
                <b-dropdown right split :text="$t('buttons.settings.save_and_publish')" class="float-right"
                            variant="success" size="sm" @click="onSubmit()"
                            :disabled="pending"
                            v-if="isNew || this.$app.user.can('edit settings') || this.$app.user.can('edit own settings')"
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
import settingsform from '../mixins/settingsform'

export default {
  name: 'SettingsForm',
  mixins: [settingsform],
  data () {
    return {
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: true
      },
      modelName: 'setting',
      resourceRoute: 'settings',
      listPath: '/settings',
      jobcards: [],
      selectedLogo: {},
      model: {
        company_name: null,
        company_address: null,
        new_company_logo: null,
        company_logo: null,
        bank_account: null,
        quote_ref_start: null,
        quote_vat: null
      }
    }
  },
  methods: {
    onFileSelected: function (event) {
      this.selectedLogo = event.target.files[0]
      this.model.new_company_logo = event.target.files[0].name
      console.log(this.selectedLogo)
    }
  }
}
</script>
