<template>
  <div class="ageing-report">
    <b-card>
      <template slot="header">
        <h3 class="card-title">Ageing Report</h3>
      </template>
      <b-datatable
        ref="datasource"
        @context-changed="onContextChanged"
        search-route="admin.invoices.ageingreport"
        delete-route="admin.invoices.destroy"
        action-route="admin.invoices.batch_action"
        :selected.sync="selected"
        :search="false"
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
          <template slot="invoice_status" slot-scope="row">
            <span class="invoice-status" v-text="row.item.invoice_status"></span>
          </template>
          <template slot="net_amount" slot-scope="row">
            <span>$ {{ row.item.net_amount }}</span>
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

export default {
  name: 'AgeingReport',
  data () {
    return {
      selected: [],
      countsData: null,
      totalPaid: '0.00',
      totalOwned: '0.00',
      fields: [
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
  methods: {
    dataLoadProvider (ctx) {
      return this.$refs.datasource.loadData(ctx.sortBy, ctx.sortDesc)
    },
    onContextChanged () {
      return this.$refs.datatable.refresh()
    },
    onDelete (id) {
      this.$refs.datasource.deleteRow({ report: id })
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
