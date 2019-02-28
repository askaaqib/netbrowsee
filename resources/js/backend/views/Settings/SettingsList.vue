<template>
  <div>
    <b-card>
      <template slot="header">
        <h3 class="card-title">{{ $t('labels.backend.settings.titles.index') }}</h3>
        <div class="card-options" v-if="this.$app.user.can('create settings')">
          <b-button to="/settings/create" variant="success" size="sm">
            <i class="fe fe-plus-circle"></i> {{ $t('buttons.settings.create') }}
          </b-button>
        </div>
      </template>
      <b-datatable ref="datasource"
                   @context-changed="onContextChanged"
                   search-route="admin.settings.search"
                   delete-route="admin.settings.destroy"
                   action-route="admin.settings.batch_action" :actions="actions"
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
                 sort-by="settings.created_at"
                 :sort-desc="true"
        >
          <template slot="HEAD_checkbox" slot-scope="data"></template>
          <template slot="checkbox" slot-scope="row">
            <b-form-checkbox :value="row.item.id" v-model="selected"></b-form-checkbox>
          </template>
          <template slot="company_name" slot-scope="row">
            <span v-text="row.item.company_name"></span>
          </template>
          <template slot="company_address" slot-scope="row">
            <span v-text="row.item.company_address"></span>
          </template>
          <template slot="bank_account" slot-scope="row">
            <span v-text="row.item.bank_account"></span>
          </template>
          <template slot="quote_ref_start" slot-scope="row">
            <span v-text="row.item.quote_ref_start"></span>
          </template>
          <template slot="settings.created_at" slot-scope="row">
            {{ row.item.created_at }}
          </template>
          <template slot="settings.updated_at" slot-scope="row">
            {{ row.item.updated_at }}
          </template>
          <template slot="actions" slot-scope="row">
            <b-button v-if="row.item.id" size="sm" variant="primary" :to="`/settings/${row.item.id}/edit`" v-b-tooltip.hover :title="$t('buttons.edit')" class="mr-1">
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
  name: 'SettingsList',
  data () {
    return {
      selected: [],
      fields: [
        { key: 'checkbox' },
        { key: 'company_name', label: this.$t('validation.settings.company_name'), sortable: true },
        { key: 'company_address', label: this.$t('validation.settings.company_address'), sortable: true },
        { key: 'bank_account', label: this.$t('validation.settings.bank_account'), sortable: true },
        { key: 'quote_ref_start', label: this.$t('validation.settings.quote_ref_start'), sortable: true },
        { key: 'settings.created_at', label: this.$t('labels.created_at'), 'class': 'text-center', sortable: true },
        { key: 'settings.updated_at', label: this.$t('labels.updated_at'), 'class': 'text-center', sortable: true },
        { key: 'actions', label: this.$t('labels.actions'), 'class': 'nowrap' }
      ],
      actions: {
        destroy: this.$t('labels.backend.settings.actions.destroy')
      }
    }
  },
  mounted: function () {
    this.$router.push('/settings/create')
  },
  methods: {
    dataLoadProvider (ctx) {
      return this.$refs.datasource.loadData(ctx.sortBy, ctx.sortDesc)
    },
    onContextChanged () {
      return this.$refs.datatable.refresh()
    },
    onDelete (id) {
      this.$refs.datasource.deleteRow({ setting: id })
    }
  }
}
</script>
