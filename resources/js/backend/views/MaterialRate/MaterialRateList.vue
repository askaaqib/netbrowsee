<template>
  <div>
    <b-card>
      <template slot="header">
        <h3 class="card-title">{{ $t('labels.backend.materials_rates.titles.index') }}</h3>
        <div class="card-options" v-if="this.$app.user.can('create materials_rates')">
          <b-button to="/materials_rates/create" variant="success" size="sm">
            <i class="fe fe-plus-circle"></i> {{ $t('buttons.materials_rates.create') }}
          </b-button>
        </div>
      </template>
      <b-datatable ref="datasource"
                   @context-changed="onContextChanged"
                   search-route="admin.materials_rates.search"
                   delete-route="admin.materials_rates.destroy"
                   action-route="admin.materials_rates.batch_action" :actions="actions"
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
                 sort-by="materials_rates.created_at"
                 :sort-desc="true"
        >
          <template slot="HEAD_checkbox" slot-scope="data"></template>
          <template slot="checkbox" slot-scope="row">
            <b-form-checkbox :value="row.item.id" v-model="selected"></b-form-checkbox>
          </template>
          <template slot="name" slot-scope="row">
            <span v-text="row.item.name"></span>
          </template>
          <template slot="description" slot-scope="row">
            <span v-text="row.item.description"></span>
          </template>
          <template slot="materials_rates.created_at" slot-scope="row">
            {{ row.item.created_at }}
          </template>
          <template slot="materials_rates.updated_at" slot-scope="row">
            {{ row.item.updated_at }}
          </template>
          <template slot="actions" slot-scope="row">
            <b-button v-if="row.item.id" size="sm" variant="primary" :to="`/materials_rates/${row.item.id}/edit`" v-b-tooltip.hover :title="$t('buttons.edit')" class="mr-1">
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
  name: 'MaterialRateList',
  data () {
    return {
      selected: [],
      fields: [
        { key: 'checkbox' },
        { key: 'name', label: this.$t('validation.attributes.name'), sortable: true },
        { key: 'rate', label: this.$t('validation.attributes.description'), sortable: true },
        { key: 'materials_rates.created_at', label: this.$t('labels.created_at'), 'class': 'text-center', sortable: true },
        { key: 'materials_rates.updated_at', label: this.$t('labels.updated_at'), 'class': 'text-center', sortable: true },
        { key: 'actions', label: this.$t('labels.actions'), 'class': 'nowrap' }
      ],
      actions: {
        destroy: this.$t('labels.backend.materials_rates.actions.destroy')
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
      this.$refs.datasource.deleteRow({ materials_rate: id })
    }
  }
}
</script>
