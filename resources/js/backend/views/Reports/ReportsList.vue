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
        search-route="admin.reports.jobcardreports"
        delete-route="admin.reports.destroy"
        action-route="admin.reports.batch_action"
        :actions="actions"
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
          sort-by="reports.created_at"
          :sort-desc="true"
        >
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
            <span v-if="row.item.status == 1">Received</span>
            <span v-if="row.item.status == 2">Assigned</span>
            <span v-if="row.item.status == 3">On Hold</span>
            <span v-if="row.item.status == 4">Completed</span>
            <span v-if="row.item.status == 5">Submitted for Vetting</span>
            <span v-if="row.item.status == 6">Invoiced</span>
            <span v-if="row.item.status == 7">Paid</span>
            <span v-if="row.item.status == 8">Cancelled</span>
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
        { key: 'jobcard_num', label: 'Jobcard Number' },
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
