<template>
  <div>
    <b-card>
      <template slot="header">
        <h3 class="card-title">{{ $t('labels.backend.contact.titles.index') }}</h3>
      </template>
      <b-datatable ref="datasource"
                   @context-changed="onContextChanged"
                   search-route="admin.contact.search"
                   delete-route="admin.contact.destroy"
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
        > 
          <template slot="name" slot-scope="row">
            <router-link :to="`/contact/${row.item.id}/view`" v-text="row.item.users_name.name"></router-link>
          </template>
          <template slot="subject" slot-scope="row">
            <span v-text="row.item.subject"></span>
          </template>
          <template slot="message" slot-scope="row">
            <span v-text="row.item.message"></span>
          </template>
        </b-table>
      </b-datatable>
    </b-card>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'StatusReportList',
  data() {
    return {
      selected: [],
      fields: [
        {
          key: 'name',
          label: this.$t('validation.attributes.customer_name'),
          sortable: true
        },
        {
          key: 'subject',
          label: this.$t('validation.attributes.subject'),
          sortable: true
        },
        {
          key: 'message',
          label: this.$t('validation.attributes.message')
        }
      ]
    }
  },
  methods: {
    dataLoadProvider(ctx) {
      return this.$refs.datasource.loadData(ctx.sortBy, ctx.sortDesc)
    },
    onContextChanged() {
      return this.$refs.datatable.refresh()
    },
    onDelete(id) {
      this.$refs.datasource.deleteRow({ bank: id })
    }
  }
}
</script>
