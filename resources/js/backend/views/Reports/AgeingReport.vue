<template>
  <div class="ageing-report" id="ageing-report">
    <b-card>
      <template slot="header">
        <h3 class="card-title">Ageing Reports</h3>
      </template>
      <template class="pull-right">
          <div id="hideprint" class="pull-right">
            <b-btn class="btn-show pull-right" id="download" variant="secondary" @click="printFacture()">Download Pdf<i class="fe fe-file fe-lg"></i></b-btn>
          </div>
      </template>
      <b-datatable
        ref="datasource"
        @context-changed="onContextChanged"
        search-route="admin.invoices.ageingreport"
        delete-route="admin.invoices.destroy"
        action-route="admin.invoices.batch_action"
        :selected.sync="selected"
        :search="true"
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
          id="table-view"
          v-model="rows"
        >

          <template slot="created_at" slot-scope="row">
            <span class="created_at" v-text="row.item.created_at"></span>
          </template>
          <template slot="invoice_status" slot-scope="row">
            <span class="invoice-status" v-text="row.item.invoice_status"></span>
          </template>
          <template slot="net_amount" slot-scope="row">
            <span>$ {{ parseFloat(row.item.net_amount).toFixed(2) }}</span>
          </template>
          <template slot="bottom-row" slot-scope="row" >
            <td>Total</td>
            <td></td>
            <td>$ {{ parseFloat(netAmount).toFixed(2) }}</td>
            <td></td>
          </template>
        </b-table>
      </b-datatable>
    </b-card>
    <b-card>
      <h3>Money Owned</h3>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Less than 30 Days</th>
            <th>30 Days +</th>
            <th>60 Days +</th>
            <th>90 Days +</th>
            <th>120 Days +</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="countsData">
            <td>$ {{ countsData.less_30 }}</td>
            <td>$ {{ countsData.plus_30 }}</td>
            <td>$ {{ countsData.plus_60 }}</td>
            <td>$ {{ countsData.plus_90 }}</td>
            <td>$ {{ countsData.plus_120 }}</td>
          </tr>
        </tbody>
      </table>
    </b-card>
    <b-card>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Total Paid</th>
            <th>Total Owned</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>$ {{ totalPaid }}</td>
            <td>$ {{ totalOwned }}</td>
          </tr>
        </tbody>
      </table>
    </b-card>
  </div>
</template>

<script>
import axios from 'axios'
import html2pdf from 'html2pdf.js'
import { setTimeout } from 'timers'

export default {
  name: 'AgeingReport',
  data () {
    return {
      selected: [],
      countsData: null,
      totalPaid: '0.00',
      totalOwned: '0.00',
      rows: [],
      fields: [
        { key: 'created_at', label: 'Date' },
        { key: 'invoice_number', label: 'Invoice #' },
        { key: 'net_amount', label: 'Amount before VAT' },
        { key: 'invoice_status', label: 'Status' }
      ],
      actions: {
        destroy: this.$t('labels.backend.invoices.actions.destroy')
      }
    }
  },
  created () {
    this.getInvoiceRecords()
  },
  computed: {
    netAmount: function () {
      return this.rows.reduce((accum, item) => {
      // Assuming expenses is the field you want to total up
        return accum + parseFloat(item.net_amount)
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
      var elementor = document.getElementById('ageing-report')
      html2pdf(elementor, {
        margin: 1.5,
        filename: 'ageingReport.pdf',
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
    },
    async getInvoiceRecords () {
      await axios.get(this.$app.route('admin.invoices.getInvoiceRecords')).then((result) => {
        if (result.data.status === 200) {
          this.countsData = result.data.counts
          this.totalPaid = result.data.total_paid
          this.totalOwned = result.data.total_owned
        }
      })
    }
  }
}
</script>
