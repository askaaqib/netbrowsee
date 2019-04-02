<template>
  <div>
    <b-card>
      <template slot="header">
        <h3 class="card-title">{{ $t('labels.backend.reports.titles.index') }}</h3>
        <div class="card-options" v-if="this.$app.user.can('create reports')">
          <b-button to="/reports/create" variant="success" size="sm">
            <i class="fe fe-plus-circle"></i> {{ $t('buttons.reports.create') }}
          </b-button>
        </div>
      </template>
      <b-datatable
        ref="datasource"
        @context-changed="onContextChanged"
        search-route="admin.jobcard.jobcardreports"
        delete-route="admin.reports.destroy"
        action-route="admin.reports.batch_action"
        :actions="actions"
        :selected.sync="selected"
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
          sort-by="reports.created_at"
          :sort-desc="true"
        >
          <template slot="created_at" slot-scope="row">
            <span>{{ row.item.created_at }}</span>
          </template>
          <template slot="expenses" slot-scope="row">
            <span>$ {{ row.item.expenses }}</span>
          </template>
          <template slot="quote_amount" slot-scope="row">
            <span>$ {{ row.item.quote_amount }}</span>
          </template>
          <template slot="profit" slot-scope="row">
            <span>$ {{ parseFloat(row.item.expenses) - parseFloat(row.item.quote_amount) }}</span>
          </template>
          <template slot="status" slot-scope="row">
            <span v-if="row.item.status == 'received'">Received</span>
            <span v-if="row.item.status == 'assigned'">Assigned</span>
            <span v-if="row.item.status == 'on hold'">On Hold</span>
            <span v-if="row.item.status == 'completed'">Completed</span>
            <span v-if="row.item.status == 'submitted for vetting'">Submitted for Vetting</span>
            <span v-if="row.item.status == 'invoiced'">Invoiced</span>
            <span v-if="row.item.status == 'paid'">Paid</span>
            <span v-if="row.item.status == 'cancelled'">Cancelled</span>
          </template>
        </b-table>
      </b-datatable>
    </b-card>
  </div>
</template>

<script>

export default {
  name: 'ReportsList',
  data () {
    return {
      selected: [],
      fields: [
        { key: 'created_at', label: 'Date' },
        { key: 'jobcard_num', label: 'Jobcard #' },
        { key: 'expenses', label: 'Expenses' },
        { key: 'quote_amount', label: 'Quoted Amount' },
        { key: 'profit', label: 'Profit' },
        { key: 'status', label: 'Status' }
      ],
      actions: {
        destroy: this.$t('labels.backend.reports.actions.destroy')
      }
    }
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
    }
  }
}
</script>
