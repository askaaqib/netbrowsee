<template>
  <div class="status-report" >
    <b-card>
      <template slot="header">
        <h3 class="card-title">Status Reports</h3>
      </template>
      <template class="pull-right">
        <div id="hideprint" class="pull-right">
          <b-btn class="btn-show pull-right" id="download" variant="secondary" @click="printFacture()">Download Pdf<i class="fe fe-file fe-lg"></i></b-btn>
        </div>
      </template>
      <b-datatable
        ref="datasource"
        @context-changed="onContextChanged"
        search-route="admin.jobcard.statusreport"
        delete-route="admin.jobcard.destroy"
        action-route="admin.jobcard.batch_action"
        :selected.sync="selected"
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
          sort-by="jobcard.created_at"
          :sort-desc="true"
          id="status-report"
        >
          <template slot="created_at" slot-scope="row">
            <span>{{ row.item.created_at }}</span>
          </template>
          <template slot="project_manager" slot-scope="row">
            <span>{{ row.item.get_project_manager.name }}</span>
          </template>
          <template slot="assigned_user" slot-scope="row">
            <span>{{ row.item.get_assigned_user.name }}</span>
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
import html2pdf from 'html2pdf.js'
import { setTimeout } from 'timers'

export default {
  name: 'StatusReport',
  data () {
    return {
      selected: [],
      fields: [
        { key: 'created_at', label: 'Date' },
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
    },
    printFacture: function () {
      this.HideButtons()
      var elementor = document.getElementById('status-report')
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
    }
  }
}
</script>
