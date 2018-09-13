<template>
  <div>
    <form @submit.prevent="onSubmit">
      <b-row>
        <b-col xl="12">
          <b-card>
            <h3 class="card-title" slot="header">{{ isNew ? $t('labels.backend.quotes.titles.create') : $t('labels.backend.quotes.titles.edit') }}</h3>
            <b-form-group
              :label="$t('validation.quotes.quotes_num')"
              label-for="quotes_num"
              horizontal
              :label-cols="2"
              :feedback="feedback('quotes_num')"
            >
              <b-form-input
                id="quotes_num"
                name="quotes_num"
                required
                :placeholder="$t('validation.quotes.quotes_num')"
                v-model="model.quotation_number"
                :state="state('quotes_num')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.quotes_name')"
              label-for="quotes_name"
              horizontal
              :label-cols="2"
              :feedback="feedback('quotes_name')"
            >
              <b-form-textarea
                id="quotes_name"
                name="quotes_name"
                :rows="3"
                :placeholder="$t('validation.quotes.quotes_name')"
                v-model="model.quotation_name"
                :state="state('quotes_name')"
              ></b-form-textarea>
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
                required
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
                required
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
                required
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
                required
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
                required
                :placeholder="$t('validation.quotes.total_amount')"
                v-model="model.total_amount"
                :state="state('total_amount')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.client_id')"
              label-for="client_id"
              horizontal
              :label-cols="2"
              :feedback="feedback('client_id')"
            >
              <b-form-input
                id="client_id"
                name="client_id"
                required
                :placeholder="$t('validation.quotes.client_id')"
                v-model="model.client_id"
                :state="state('client_id')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.quotation_date')"
              label-for="quotation_date"
              horizontal
              :label-cols="2"
              :feedback="feedback('quotation_date')"
            >
              <b-form-input
                id="quotation_date"
                name="quotation_date"
                required
                :placeholder="$t('validation.quotes.quotation_date')"
                v-model="model.quotation_date"
                :state="state('quotation_date')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.labour_rates_id')"
              label-for="labour_rates_id"
              horizontal
              :label-cols="2"
              :feedback="feedback('labour_rates_id')"
            >
              <b-form-input
                id="labour_rates_id"
                name="labour_rates_id"
                required
                :placeholder="$t('validation.quotes.labour_rates_id')"
                v-model="model.labour_rates_id"
                :state="state('labour_rates_id')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.vat_id')"
              label-for="vat_id"
              horizontal
              :label-cols="2"
              :feedback="feedback('vat_id')"
            >
              <b-form-input
                id="vat_id"
                name="vat_id"
                required
                :placeholder="$t('validation.quotes.vat_id')"
                v-model="model.vat_id"
                :state="state('vat_id')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.material_rates_id')"
              label-for="material_rates_id"
              horizontal
              :label-cols="2"
              :feedback="feedback('material_rates_id')"
            >
              <b-form-input
                id="material_rates_id"
                name="material_rates_id"
                required
                :placeholder="$t('validation.quotes.material_rates_id')"
                v-model="model.materials_rates_id"
                :state="state('material_rates_id')"
              ></b-form-input>
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
import form from '../mixins/form'

export default {
  name: 'PostForm',
  mixins: [form],
  data () {
    return {
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: true
      },
      modelName: 'quotesss',
      resourceRoute: 'quotes',
      listPath: '/quotes',
      tags: [],
      model: {
        quotation_number: null,
        quotation_name: null,
        travelling_time: null,
        travelling_km: null,
        vat_amount: null,
        net_amount: null,
        total_amount: null,
        client_id: null,
        quotation_date: null,
        labour_rates_id: null,
        materials_rates_id: null,
        vat_id: null
      }
    }
  }
}
</script>
