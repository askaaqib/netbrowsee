<template>
  <div>
    <form @submit.prevent="onSubmit">
      <b-row>
        <b-col xl="8">
          <b-card>
            <h3 class="card-title" slot="header">{{ isNew ? $t('labels.backend.invoices.titles.create') : $t('labels.backend.invoices.titles.edit') }}</h3>
            <b-form-group
              :label="$t('validation.invoices.description')"
              label-for="description"
              horizontal
              :label-cols="2"
              :feedback="feedback('description')"
            >
              <b-form-textarea
                id="description"
                name="description"
                :rows="5"
                :placeholder="$t('validation.invoices.description')"
                v-model="model.description"
                :state="state('description')"
              ></b-form-textarea>
            </b-form-group>

            <b-form-group
              :label="$t('validation.invoices.quantity')"
              label-for="quantity"
              horizontal
              :label-cols="2"
              :feedback="feedback('quantity')"
            >
              <b-form-input
                id="quantity"
                name="quantity"
                required
                :placeholder="$t('validation.invoices.quantity')"
                v-model="model.quantity"
                :state="state('quantity')"
              ></b-form-input>

            </b-form-group>

            <b-form-group
              :label="$t('validation.invoices.amount')"
              label-for="amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('amount')"
            >
              <b-form-input
                id="amount"
                name="amount"
                required
                :placeholder="$t('validation.invoices.amount')"
                v-model="model.amount"
                :state="state('amount')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.invoices.net_amount')"
              label-for="net_amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('net_amount')"
            >
              <b-form-input
                id="net_amount"
                name="net_amount"
                required
                :placeholder="$t('validation.invoices.net_amount')"
                v-model="model.net_amount"
                :state="state('net_amount')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.invoices.vat_amount')"
              label-for="vat_amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('vat_amount')"
            >
              <b-form-input
                id="vat_amount"
                name="vat_amount"
                required
                :placeholder="$t('validation.invoices.vat_amount')"
                v-model="model.vat_amount"
                :state="state('vat_amount')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.invoices.total_amount')"
              label-for="total_amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('total_amount')"
            >
              <b-form-input
                id="total_amount"
                name="total_amount"
                required
                :placeholder="$t('validation.invoices.total_amount')"
                v-model="model.total_amount"
                :state="state('total_amount')"
              ></b-form-input>
            </b-form-group>

            <b-row slot="footer">
              <b-col md>
                <b-button to="/invoices" exact variant="danger" size="md">
                  {{ $t('buttons.back') }}
                </b-button>
              </b-col>
              <b-col md>
                <b-dropdown right split :text="$t('buttons.invoices.save_and_publish')" class="float-right"
                            variant="success" size="sm" @click="onSubmit()"
                            :disabled="pending"
                            v-if="isNew || this.$app.user.can('edit invoices') || this.$app.user.can('edit own invoices')"
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
      model: {
        description: null,
        quantity: null,
        amount: null,
        net_amount: null,
        vat_amount: null,
        total_amount: null
      }
    }
  }
}
</script>
