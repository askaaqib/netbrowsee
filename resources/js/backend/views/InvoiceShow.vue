<template>
  <div>
    <form>
      <b-row>
        <b-col xl="8">
          <b-card>
            <h3 class="card-title" slot="header"></h3>
            <b-form-group
              :label="$t('validation.invoices.description')"
              label-for="description"
              horizontal
              :label-cols="2"
              :feedback="feedback('description')"
            >
              <p>{{ model.description }}</p>

            </b-form-group>

            <b-form-group
              :label="$t('validation.invoices.quantity')"
              label-for="quantity"
              horizontal
              :label-cols="2"
              :feedback="feedback('quantity')"
            >
              <p>{{ model.quantity }}</p>

            </b-form-group>

            <b-form-group
              :label="$t('validation.invoices.amount')"
              label-for="amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('amount')"
            >
              <p>{{ model.amount }}</p>
            </b-form-group>

            <b-form-group
              :label="$t('validation.invoices.net_amount')"
              label-for="net_amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('net_amount')"
            >
              <p>{{ model.net_amount }}</p>
            </b-form-group>

            <b-form-group
              :label="$t('validation.invoices.vat_amount')"
              label-for="vat_amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('vat_amount')"
            >
              <p>{{ model.vat_amount }}</p>
            </b-form-group>

            <b-form-group
              :label="$t('validation.invoices.total_amount')"
              label-for="total_amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('total_amount')"
            >
              <p>{{ model.total_amount }}</p>
            </b-form-group>

            <b-form-group
              :label="$t('validation.invoices.vat_id')"
              label-for="vat_id"
              horizontal
              :label-cols="2"
              :feedback="feedback('vat_id')"
            >
              <v-select
                id="vat_id"
                name="vat_id"
                v-model="model.vat_id"
                :options="vats"
                placeholder="Select Vat"
                label="name"
                @search-change="getVats"
              >
              </v-select>
            </b-form-group>

            <b-form-group
              :label="$t('validation.invoices.materials_rates_id')"
              label-for="materials_rates_id"
              horizontal
              :label-cols="2"
              :feedback="feedback('materials_rates_id')"
            >
              <v-select
                id="materials_rates_id"
                name="materials_rates_id"
                v-model="model.materials_rates_id"
                :options="materials_rates"
                placeholder="Select Materials Paid"
                label="name"
                @search-change="getMaterials"
              >
              </v-select>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.quotations')"
              label-for="quotations_id"
              horizontal
              :label-cols="2"
              :feedback="feedback('quotations_id')"
            >
              <v-select
                id="quotations_id"
                name="quotations_id"
                v-model="model.quotations_id"
                :options="quotations"
                placeholder="Select Quotations"
                label="quotation_name"
                @search-change="getQuotations"
              >
              </v-select>
            </b-form-group>
            <b-row slot="footer">
              <b-col md>
                <b-button to="/invoices" exact variant="danger" size="md">
                  {{ $t('buttons.back') }}
                </b-button>
              </b-col>
              <b-col md>
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
  name: 'InvoicesForm',
  mixins: [form],
  data () {
    return {
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: true
      },
      modelName: 'invoice',
      resourceRoute: 'invoices',
      listPath: '/invoices',
      materials_rates: [],
      quotations: [],
      vats: [],
      model: {
        description: null,
        quantity: null,
        amount: null,
        net_amount: null,
        vat_amount: null,
        total_amount: null,
        materials_rates_id: [],
        quotations_id: [],
        vat_id: []
      }
    }
  },
  created: function () {
    this.getMaterials()
    this.getQuotations()
    this.getVats()
  },
  methods: {
    async getMaterials () {
      let { data } = await axios.get(this.$app.route('admin.materials.getdata'), {})

      this.materials_rates = data
    },
    async getQuotations () {
      let { data } = await axios.get(this.$app.route('admin.quotations.getdata'), {})

      this.quotations = data
    },
    async getVats () {
      let { data } = await axios.get(this.$app.route('admin.vats.getdata'), {})

      this.vats = data
    }
  }
}
</script>
