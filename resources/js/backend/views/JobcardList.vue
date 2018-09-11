<template>
  <div>
    <b-card>
      <template slot="header">
        <h3 class="card-title">{{ $t('labels.backend.jobcards.titles.index') }}</h3>
        <div class="card-options" v-if="this.$app.user.can('create jobcards')">
          <b-button to="/jobcards/create" variant="success" size="sm">
            <i class="fe fe-plus-circle"></i> {{ $t('buttons.jobcards.create') }}
          </b-button>
        </div>
      </template>
      <b-datatable ref="datasource"
                   @context-changed="onContextChanged"
                   search-route="admin.jobcards.search"
                   delete-route="admin.jobcards.destroy"
                   action-route="admin.jobcards.batch_action" :actions="actions"
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
                 sort-by="jobcard.created_at"
                 :sort-desc="true"
        >
          <template slot="HEAD_checkbox" slot-scope="data"></template>
          <template slot="checkbox" slot-scope="row">
            <b-form-checkbox :value="row.item.id" v-model="selected"></b-form-checkbox>
          </template>
          <template slot-scope="row">
            <span v-text="row.item.id"></span>
          </template>
          <template slot="actions" slot-scope="row">
            <b-button size="sm" variant="success" target="_blank" v-b-tooltip.hover :title="$t('buttons.preview')" class="mr-1">
              <i class="fe fe-eye"></i>
            </b-button>
            <b-button v-if="row.item.id" size="sm" variant="primary" :to="`/jobcards/${row.item.id}/edit`" v-b-tooltip.hover :title="$t('buttons.edit')" class="mr-1">
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
  name: 'JobcardList',
  data () {
    return {
      selected: [],
      fields: [
        { key: 'checkbox' },
        { key: 'jobcard_num', label: this.$t('validation.jobcards.jobcard_num'), sortable: true },
        { key: 'jobcards.created_at', label: this.$t('labels.created_at'), 'class': 'text-center', sortable: true },
        { key: 'jobcards.updated_at', label: this.$t('labels.updated_at'), 'class': 'text-center', sortable: true },
        { key: 'actions', label: this.$t('labels.actions'), 'class': 'nowrap' }
      ],
      actions: {
        destroy: this.$t('labels.backend.jobcards.actions.destroy'),
        publish: this.$t('labels.backend.jobcards.actions.publish')
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
      this.$refs.datasource.deleteRow({ post: id })
    }
  }
}
</script>
