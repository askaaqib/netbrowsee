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
      <b-datatable ref="datasource"
                   @context-changed="onContextChanged"
                   search-route="admin.reports.search"
                   delete-route="admin.reports.destroy"
                   action-route="admin.reports.batch_action" :actions="actions"
                   :selected.sync="selected"
      >
        <b-table ref="datatable"
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
          <template slot="HEAD_checkbox" slot-scope="data"></template>
          <template slot="checkbox" slot-scope="row">
            <b-form-checkbox :value="row.item.id" v-model="selected"></b-form-checkbox>
          </template>
          <template slot="description" slot-scope="row">
            <span v-text="row.item.description"></span>
          </template>
          <template slot="status" slot-scope="row">
            <span v-text="row.item.status"></span>
          </template>
          <template slot="expenses" slot-scope="row">
            <span v-text="row.item.expenses"></span>
          </template>
          <template slot="amount" slot-scope="row">
            <span v-text="row.item.amount"></span>
          </template>
          <template slot="vat_collected" slot-scope="row">
            <span v-text="row.item.vat_collected"></span>
          </template>
          <template slot="profit_loss" slot-scope="row">
            <span v-text="row.item.profit_loss"></span>
          </template>
          <template slot="reports.created_at" slot-scope="row">
            {{ row.item.created_at }}
          </template>
          <template slot="reports.updated_at" slot-scope="row">
            {{ row.item.updated_at }}
          </template>
          <template slot="actions" slot-scope="row">
            <b-button v-if="row.item.id" size="sm" variant="primary" :to="`/reports/${row.item.id}/edit`" v-b-tooltip.hover :title="$t('buttons.edit')" class="mr-1">
              <i class="fe fe-edit"></i>
            </b-button>
            <b-button v-if="row.item.id" size="sm" variant="danger" v-b-tooltip.hover :title="$t('buttons.delete')" @click.stop="onDelete(row.item.id)">
              <i class="fe fe-trash"></i>
            </b-button>
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
        { key: 'checkbox' },
        { key: 'description', label: this.$t('validation.reports.description'), sortable: true },
        { key: 'status', label: this.$t('validation.reports.status'), sortable: true },
        { key: 'expenses', label: this.$t('validation.reports.expenses'), sortable: true },
        { key: 'amount', label: this.$t('validation.reports.amount'), sortable: true },
        { key: 'vat_collected', label: this.$t('validation.reports.vat_collected'), sortable: true },
        { key: 'profit_loss', label: this.$t('validation.reports.profit_loss'), sortable: true },
        { key: 'reports.created_at', label: this.$t('labels.created_at'), 'class': 'text-center', sortable: true },
        { key: 'reports.updated_at', label: this.$t('labels.updated_at'), 'class': 'text-center', sortable: true },
        { key: 'actions', label: this.$t('labels.actions'), 'class': 'nowrap' }
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
