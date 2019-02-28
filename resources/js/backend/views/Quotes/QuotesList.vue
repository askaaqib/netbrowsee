<template>
  <div>
    <b-card>
      <template slot="header">
        <h3 class="card-title">{{ $t('labels.backend.quotes.titles.index') }}</h3>
        <div class="card-options" v-if="this.$app.user.can('create quotes')">
          <b-button to="/quotes/create" variant="success" size="sm">
            <i class="fe fe-plus-circle"></i> {{ $t('buttons.quotes.create') }}
          </b-button>
        </div>
      </template>
      <b-datatable ref="datasource"
                   @context-changed="onContextChanged"
                   search-route="admin.quotes.search"
                   delete-route="admin.quotes.destroy"
                   action-route="admin.quotes.batch_action" :actions="actions"
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
                 sort-by="quotes.created_at"
                 :sort-desc="true"
        >
          <template slot="HEAD_checkbox" slot-scope="data"></template>
          <template slot="checkbox" slot-scope="row">
            <b-form-checkbox :value="row.item.id" v-model="selected"></b-form-checkbox>
          </template>
          <template slot="quotation_number" slot-scope="row">
            <span v-text="row.item.quotation_digit"></span>-<span v-text="row.item.quotation_number"></span>
          </template>
          <template slot="quotation_name" slot-scope="row">
            <span v-text="row.item.quotation_name"></span>
          </template>
          <template slot="quotes.created_at" slot-scope="row">
            {{ row.item.created_at }}
          </template>
          <template slot="quotes.updated_at" slot-scope="row">
            {{ row.item.updated_at }}
          </template>
          <template slot="actions" slot-scope="row">
            <b-button size="sm" variant="success" :to="`/quotes/${row.item.id}/view`" v-b-tooltip.hover :title="$t('buttons.preview')" class="mr-1">
              <i class="fe fe-eye"></i>
            </b-button>
            <b-button v-if="row.item.id" size="sm" variant="primary" :to="`/quotes/${row.item.id}/edit`" v-b-tooltip.hover :title="$t('buttons.edit')" class="mr-1">
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
  name: 'QuotesList',
  data () {
    return {
      selected: [],
      fields: [
        { key: 'checkbox' },
        { key: 'quotation_number', label: this.$t('validation.quotes.quotation_number'), sortable: true },
        { key: 'quotation_name', label: this.$t('validation.quotes.quotation_name'), sortable: true },
        { key: 'quotes.created_at', label: this.$t('labels.created_at'), 'class': 'text-center', sortable: true },
        { key: 'quotes.updated_at', label: this.$t('labels.updated_at'), 'class': 'text-center', sortable: true },
        { key: 'actions', label: this.$t('labels.actions'), 'class': 'nowrap' }
      ],
      actions: {
        destroy: this.$t('labels.backend.quotes.actions.destroy')
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
      this.$refs.datasource.deleteRow({ quote: id })
    }
  }
}
</script>
