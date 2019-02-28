<template>
  <div>
    <b-card>
      <template slot="header">
        <h3 class="card-title">{{ $t('labels.backend.subdistrict.titles.index') }}</h3>
        <div class="card-options" v-if="this.$app.user.can('create subdistrict')">
          <b-button to="/subdistricts/create" variant="success" size="sm">
            <i class="fe fe-plus-circle"></i> {{ $t('buttons.subdistrict.create') }}
          </b-button>
        </div>
      </template>
      <b-datatable ref="datasource"
                   @context-changed="onContextChanged"
                   search-route="admin.subdistricts.search"
                   delete-route="admin.subdistricts.destroy"
                   action-route="admin.subdistricts.batch_action" :actions="actions"
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
                 sort-by="subdistrict.created_at"
                 :sort-desc="true"
        >
          <template slot="HEAD_checkbox" slot-scope="data"></template>
          <template slot="checkbox" slot-scope="row">
            <b-form-checkbox :value="row.item.id" v-model="selected"></b-form-checkbox>
          </template>
          <template slot="name" slot-scope="row">
            <span v-text="row.item.name"></span>
          </template>
          <template slot="district" slot-scope="row">
            <span>{{ row.item.district.name }}</span>
          </template>
          <template slot="subdistrict.created_at" slot-scope="row">
            {{ row.item.created_at }}
          </template>
          <template slot="subdistrict.updated_at" slot-scope="row">
            {{ row.item.updated_at }}
          </template>
          <template slot="actions" slot-scope="row">
            <b-button v-if="row.item.id" size="sm" variant="primary" :to="`/subdistricts/${row.item.id}/edit`" v-b-tooltip.hover :title="$t('buttons.edit')" class="mr-1">
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
  name: 'SubDistrictList',
  data () {
    return {
      selected: [],
      fields: [
        { key: 'checkbox' },
        { key: 'name', label: this.$t('validation.SubDistrict.name'), sortable: true },
        { key: 'district', label: this.$t('validation.District.name'), sortable: true },
        { key: 'subdistrict.created_at', label: this.$t('labels.created_at'), 'class': 'text-center', sortable: true },
        { key: 'subdistrict.updated_at', label: this.$t('labels.updated_at'), 'class': 'text-center', sortable: true },
        { key: 'actions', label: this.$t('labels.actions'), 'class': 'nowrap' }
      ],
      actions: {
        destroy: this.$t('labels.backend.subdistrict.actions.destroy')
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
      this.$refs.datasource.deleteRow({ subdistrict: id })
    },
    getdistrict (val) {
      // console.log(val, val.district.name)
    }
  }
}

</script>
