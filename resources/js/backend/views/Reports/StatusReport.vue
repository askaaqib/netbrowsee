<template>
  <div class="ageing-report">
    <b-card>
      <template slot="header">
        <h3 class="card-title">Ageing Report</h3>
      </template>
      <b-datatable
        ref="datasource"
        @context-changed="onContextChanged"
        search-route="admin.jobcard.statusreport"
        delete-route="admin.jobcard.destroy"
        action-route="admin.jobcard.batch_action"
        :selected.sync="selected"
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
          sort-by="jobcard.created_at"
          :sort-desc="true"
        >
          <template slot="project_manager" slot-scope="row">
            <span>{{ row.item.get_project_manager.name }}</span>
          </template>
          <template slot="assigned_user" slot-scope="row">
            <span>{{ row.item.get_assigned_user.name }}</span>
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
  name: 'StatusReport',
  data () {
    return {
      selected: [],
      fields: [
        { key: 'jobcard_num', label: 'Jobcard #' },
        { key: 'description', label: 'Description' },
        { key: 'project_manager', label: 'Project Manager' },
        { key: 'assigned_user', label: 'Assigned Technician' },
        { key: 'status', label: 'Status', sortable: true }
      ],
      actions: {
        destroy: this.$t('labels.backend.jobcard.actions.destroy')
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
