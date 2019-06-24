<template>
  <div class="vat-report" id="vat-report">
    <b-card>
      <template slot="header">
        <h3 class="card-title">VAT Reports</h3>
      </template>
      <template class="pull-right">
          <div id="hideprint" class="pull-right">
            <b-btn class="btn-show pull-right" id="download" variant="secondary" @click="printFacture()">Download Pdf<i class="fe fe-file fe-lg"></i></b-btn>
          </div>
      </template>
      <b-datatable
        ref="datasource"
        @context-changed="onContextChanged"
        search-route="admin.invoices.vatreport"
        delete-route="admin.invoices.destroy"
        action-route="admin.invoices.batch_action"
        :selected.sync="selected"
        :search="true"
        :export-data="true"
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
          v-model="rows"
        >
          <template slot="created_at" slot-scope="row">
            <span>{{ row.item.created_at }}</span>
          </template>
          <template slot="vat_amount" slot-scope="row">
            <span>ZAR {{ parseFloat(row.item.vat_amount).toFixed(2) }}</span>
          </template>
          <template slot="input_vat" slot-scope="row">
            <span>ZAR {{ parseFloat(row.item.input_vat).toFixed(2) }}</span>
          </template>
          <template slot="payable_vat" slot-scope="row">
            <span>ZAR {{ parseFloat(row.item.payable_vat).toFixed(2) }}</span>
          </template>
          <template slot="bottom-row" slot-scope="row">
            <td>Total</td>
            <td></td>
            <td>ZAR {{ outputVat.toFixed(2) }}</td>
            <td>ZAR {{ inputVat.toFixed(2) }}</td>
            <td>ZAR {{ payableVat.toFixed(2) }}</td>
            <td></td>
          </template>
        </b-table>
      </b-datatable>
    </b-card>
  </div>
</template>

<script>
import html2pdf from 'html2pdf.js'
import { setTimeout } from 'timers'

export default {
  name: 'VatReport',
  data () {
    return {
      selected: [],
      rows: [],
      fields: [
        { key: 'created_at', label: 'Date' },
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
  computed: {
    outputVat: function () {
      return this.rows.reduce((accum, item) => {
      // Assuming expenses is the field you want to total up
        return accum + parseFloat(item.vat_amount)
      }, 0.00)
      // return this.$store.state.totals.expense
    },
    inputVat: function () {
      return this.rows.reduce((accum, item) => {
      // Assuming expenses is the field you want to total up
        return accum + parseFloat(item.input_vat)
      }, 0.00)
      // return this.$store.state.totals.expense
    },
    payableVat: function () {
      return this.rows.reduce((accum, item) => {
      // Assuming expenses is the field you want to total up
        return accum + parseFloat(item.payable_vat)
      }, 0.00)
      // return this.$store.state.totals.expense
    }
  },
  methods: {
    async dataLoadProvider (ctx) {
      await this.$refs.datasource.loadData(ctx.sortBy, ctx.sortDesc)
        .then((res) => {
          this.rows = res
        })
      // console.log(this.model.rows)
      return this.rows
    },
    onContextChanged () {
      return this.$refs.datatable.refresh()
    },
    onDelete (id) {
      this.$refs.datasource.deleteRow({ report: id })
    },
    printFacture: function () {
      this.HideButtons()
      var elementor = document.getElementById('vat-report')
      html2pdf(elementor, {
        margin: 1.5,
        filename: 'vatReport.pdf',
        // image: { type: 'png' },
        html2canvas: { dpi: 900, letterRendering: false },
        jsPDF: { unit: 'cm', format: 'a3', orientation: 'l' }
      })
      setTimeout(() => {
        $('.card-body .row').show()
        $('#download').show()
      }, 2000)
    },
    HideButtons: function () {
      $('.card-body .row').hide()
      $('#download').hide()
    }
  }
}
</script>
