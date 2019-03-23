<template>
  <div class="ageing-report">
    <b-card>
      <template slot="header">
        <h3 class="card-title">Ageing Report</h3>
      </template>
      <b-datatable
        ref="datasource"
        @context-changed="onContextChanged"
        search-route="admin.invoices.vatreport"
        delete-route="admin.invoices.destroy"
        action-route="admin.invoices.batch_action"
        :selected.sync="selected"
        :search="false"
        :export-data="false"
      >
        <b-table
          ref="datatable"
          striped
          bordered
          show-empty
          stacked="md"
          no-local-sorting
          :empty-text="$t('labels.datatables.no_results')"
          :empty-filtered-text="$t('labels.datatables.no_matched_results')"
          :fields="fields"
          :items="dataLoadProvider"
          sort-by="invoices.created_at"
          :sort-desc="true"
        >
          <template slot="vat_amount" slot-scope="row">
            <span>$ {{ row.item.vat_amount }}</span>
          </template>
          <template slot="input_vat" slot-scope="row">
            <span>$ {{ row.item.input_vat }}</span>
          </template>
          <template slot="payable_vat" slot-scope="row">
            <span>$ {{ row.item.payable_vat }}</span>
          </template>
        </b-table>
      </b-datatable>
    </b-card>
  </div>
</template>

<script>
export default {
  name: 'VatReport',
  data () {
    return {
      selected: [],
      fields: [
        { key: 'invoice_number', label: 'Invoice #' },
        { key: 'vat_amount', label: 'Output VAT' },
        { key: 'input_vat', label: 'Input VAT' },
        { key: 'payable_vat', label: 'Payable VAT' }
      ],
      actions: {
        destroy: this.$t('labels.backend.invoices.actions.destroy')
      }
    }
  },
  created () {},
  methods: {
    dataLoadProvider (ctx) {
      return this.$refs.datasource.loadData(ctx.sortBy, ctx.sortDesc)
    },
    onContextChanged () {
      return this.$refs.datatable.refresh()
    },
    onDelete (id) {
      this.$refs.datasource.deleteRow({ report: id })
    }
  }
}
</script>
