<template>
  <div>
    <b-card>
      <template slot="header">
        <h3 class="card-title">{{ $t('labels.backend.clients.titles.index') }}</h3>
        <div class="card-options" v-if="this.$app.user.can('create clients')">
          <b-button to="/clients/create" variant="success" size="sm">
            <i class="fe fe-plus-circle"></i> {{ $t('buttons.clients.create') }}
          </b-button>
        </div>
      </template>
      <b-datatable ref="datasource"
                   @context-changed="onContextChanged"
                   search-route="admin.clients.search"
                   delete-route="admin.clients.destroy"
                   action-route="admin.clients.batch_action" :actions="actions"
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
                 sort-by="clients.created_at"
                 :sort-desc="true"
        >
          <template slot="HEAD_checkbox" slot-scope="data"></template>
          <template slot="checkbox" slot-scope="row">
            <b-form-checkbox :value="row.item.id" v-model="selected"></b-form-checkbox>
          </template>
          <template slot="business_name" slot-scope="row">
            <span v-text="row.item.business_name"></span>
          </template>
          <template slot="clients.created_at" slot-scope="row">
            {{ row.item.created_at }}
          </template>
          <template slot="clients.updated_at" slot-scope="row">
            {{ row.item.updated_at }}
          </template>
          <template slot="actions" slot-scope="row">
            <b-button v-if="row.item.id" size="sm" variant="primary" :to="`/clients/${row.item.id}/edit`" v-b-tooltip.hover :title="$t('buttons.edit')" class="mr-1">
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
  name: 'ClientsList',
  data () {
    return {
      selected: [],
      fields: [
        { key: 'checkbox' },
        { key: 'first_name', label: this.$t('validation.clients.first_name'), sortable: true },
        { key: 'last_name', label: this.$t('validation.clients.last_name'), sortable: true },
        { key: 'business_name', label: this.$t('validation.clients.business_name'), sortable: true },
        { key: 'email', label: this.$t('validation.clients.email'), sortable: true },
        { key: 'region', label: this.$t('validation.clients.region'), sortable: true },
        { key: 'primary_phone', label: this.$t('validation.clients.primary_phone'), sortable: true },
        { key: 'notes', label: this.$t('validation.clients.notes'), sortable: true },
        { key: 'clients.created_at', label: this.$t('labels.created_at'), 'class': 'text-center', sortable: true },
        { key: 'clients.updated_at', label: this.$t('labels.updated_at'), 'class': 'text-center', sortable: true },
        { key: 'actions', label: this.$t('labels.actions'), 'class': 'nowrap' }
      ],
      actions: {
        destroy: this.$t('labels.backend.clients.actions.destroy')
      }
    }
  },
  mounted: function () {},
  methods: {
    dataLoadProvider (ctx) {
      return this.$refs.datasource.loadData(ctx.sortBy, ctx.sortDesc)
    },
    onContextChanged () {
      return this.$refs.datatable.refresh()
    },
    onDelete (id) {
      this.$refs.datasource.deleteRow({ client: id })
    }
  }
}
</script>
