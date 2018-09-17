<template>
  <div>
    <form @submit.prevent="onSubmit">
      <b-row>
        <b-col xl="8">
          <b-card>
            <h3 class="card-title" slot="header">{{ isNew ? $t('labels.backend.quotes.titles.create') : $t('labels.backend.quotes.titles.edit') }}</h3>
            <b-form-group
              :label="$t('validation.quotes.quotation_number')"
              label-for="quotation_number"
              horizontal
              :label-cols="2"
              :feedback="feedback('quotation_number')"
            >
              <b-form-input
                id="quotation_number"
                name="quotation_number"
                required
                :placeholder="$t('validation.quotes.quotation_number')"
                v-model="model.quotation_number"
                :state="state('quotation_number')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.quotation_name')"
              label-for="quotation_name"
              horizontal
              :label-cols="2"
              :feedback="feedback('quotation_name')"
            >
              <b-form-input
                id="quotation_name"
                name="quotation_name"
                :placeholder="$t('validation.quotes.quotation_name')"
                v-model="model.quotation_name"
                :state="state('quotation_name')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.travelling_time')"
              label-for="travelling_time"
              horizontal
              :label-cols="2"
              :feedback="feedback('travelling_time')"
            >
              <b-form-input
                id="travelling_time"
                name="travelling_time"
                :placeholder="$t('validation.quotes.travelling_time')"
                v-model="model.travelling_time"
                :state="state('travelling_time')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.travelling_km')"
              label-for="travelling_km"
              horizontal
              :label-cols="2"
              :feedback="feedback('travelling_km')"
            >
              <b-form-input
                id="travelling_km"
                name="travelling_km"
                :placeholder="$t('validation.quotes.travelling_km')"
                v-model="model.travelling_km"
                :state="state('travelling_km')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.vat_amount')"
              label-for="vat_amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('vat_amount')"
            >
              <b-form-input
                id="vat_amount"
                name="vat_amount"
                :placeholder="$t('validation.quotes.vat_amount')"
                v-model="model.vat_amount"
                :state="state('vat_amount')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.net_amount')"
              label-for="net_amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('net_amount')"
            >
              <b-form-input
                id="net_amount"
                name="net_amount"
                :placeholder="$t('validation.quotes.net_amount')"
                v-model="model.net_amount"
                :state="state('net_amount')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.total_amount')"
              label-for="total_amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('total_amount')"
            >
              <b-form-input
                id="total_amount"
                name="total_amount"
                :placeholder="$t('validation.quotes.total_amount')"
                v-model="model.total_amount"
                :state="state('total_amount')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.labour_rates')"
              label-for="labour_rates"
              horizontal
              :label-cols="2"
            >
              <v-select
                id="labour_rates"
                name="labour_rates"
                v-model="model.labour_rates"
                :placeholder="$t('validation.quotes.labour_rates')"
                :options="labour_rates"
                :multiple="false"
                @search-change="getLabours"
              >
              </v-select>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.material_rates')"
              label-for="materials_rates"
              horizontal
              :label-cols="2"
            >
              <v-select
                id="materials_rates"
                name="materials_rates"
                v-model="model.materials_rates"
                :placeholder="$t('validation.quotes.material_rates')"
                :options="materials_rates"
                :multiple="false"
                @search-change="getMaterials"
              >
              </v-select>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.vat_rates')"
              label-for="vat_rates"
              horizontal
              :label-cols="2"
            >
              <v-select
                id="vat_rates"
                name="vat_rates"
                v-model="model.vat_rates"
                :placeholder="$t('validation.quotes.vat_rates')"
                :options="vat_rates"
                :multiple="false"
                @search-change="getVats"
              >
              </v-select>
            </b-form-group>

            <b-row slot="footer">
              <b-col md>
                <b-button to="/quotes" exact variant="danger" size="md">
                  {{ $t('buttons.back') }}
                </b-button>
              </b-col>
              <b-col md>
                <b-dropdown right split :text="$t('buttons.quotes.save_and_publish')" class="float-right"
                            variant="success" size="sm" @click="onSubmit()"
                            :disabled="pending"
                            v-if="isNew || this.$app.user.can('edit quotes') || this.$app.user.can('edit own quotes')"
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
import axios from 'axios'
import form from '../mixins/form'

export default {
  name: 'QuotesForm',
  mixins: [form],
  data () {
    return {
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: true
      },
      modelName: 'quote',
      resourceRoute: 'quotes',
      listPath: '/quotes',
      labour_rates: [],
      materials_rates: [],
      vat_rates: [],
      model: {
        quotation_number: null,
        quotation_name: null,
        travelling_time: null,
        travelling_km: null,
        vat_amount: null,
        net_amount: null,
        total_amount: null,
        labour_rates: null,
        materials_rates: null,
        vat_rates: []
      }
    }
  },
  created: function () {
    this.getLabours()
    this.getMaterials()
    this.getVats()
  },
  methods: {
    async getLabours () {
      let { data } = await axios.get(this.$app.route('admin.labours.getids'), {})

      this.labour_rates = data.ids
    },
    async getMaterials () {
      let { data } = await axios.get(this.$app.route('admin.materials.getids'), {})

      this.materials_rates = data.ids
    },
    async getVats () {
      let { data } = await axios.get(this.$app.route('admin.vats.getids'), {})

      this.vat_rates = data.ids
    }
  }
}
</script>
