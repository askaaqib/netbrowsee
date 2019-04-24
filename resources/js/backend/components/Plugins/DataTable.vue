
<template>

  <div>
    <template
    v-if="this.$route.path === '/ageingreport'
        || this.$route.path === '/reports'
        || this.$route.path === '/vatreport'
        || this.$route.path === '/statusreport'
    ">
      <b-row>
        <b-col xl="3 pl-0 mb-5">
           <flat-pickr
            :search.sync="search"
            v-model="date"
            :config="config"
            class="form-control"
            placeholder="Select date"
            name="date"
            >
          </flat-pickr>
        </b-col>
        <b-col xl="3 pl-0 mb-5" v-if="this.$route.path === '/ageingreport'">
          <v-select v-model="client_name" id="ageing_name_type" @search-change="getageingname" :options="ageingnameOptions" placeholder="Select Client Name"></v-select>
        </b-col>
        <b-col xl="3 pl-0 mb-5" v-if="this.$route.path === '/ageingreport'">
          <v-select v-model="invoice_status" id="ageing_status_type" @search-change="getageingstatus" :options="ageingstatusOptions" placeholder="Select Status"></v-select>
        </b-col>
        <b-col xl="3 pl-0 mb-5" v-if="this.$route.path === '/statusreport'">
          <v-select v-model="technician" id="value_type" @search-change="getvalue" :options="valueOptions" placeholder="Search Technician"></v-select>
          <!-- <b-form-input v-model="technician" @keypress="" @keypress="getvalue" placeholder="Search Technician"></b-form-input> -->
        </b-col>
        <b-col xl="3 pl-0 mb-5" v-if="this.$route.path === '/statusreport'">
         <v-select v-model="manager" id="manager_type" @search-change="getmanager" :options="managerOptions" placeholder="Search manager"></v-select>
        </b-col>
        <b-col xl="3 pl-0 mb-5" v-if="this.$route.path === '/statusreport'">
          <v-select v-model="jobcardstatus" id="status_type" @search-change="getstatus" :options="statusOptions" placeholder="Search Status"></v-select>
        </b-col>
        <b-col xl="3 pl-0 mb-5">
          <b-input-group>
            <b-input-group-append>
              <b-button @click="debounceInput"
                variant="primary">
                Search
              </b-button>
            </b-input-group-append>
          </b-input-group>
        </b-col>
      </b-row>
    </template>
    <b-row>
      <b-col md="4" class="mb-3">
        <b-form inline v-if="lengthChange">
          <label class="mr-2">{{ $t('labels.datatables.show_per_page') }}</label>
          <b-form-select :options="pageOptions" v-model="perPage" class="mr-2" @input="onContextChanged"></b-form-select>
          <label>{{ $t('labels.datatables.entries_per_page') }}</label>
        </b-form>
      </b-col>
      <b-col md="4" class="mb-3 text-center">
        <label class="mt-2" v-if="infos">{{ $t('labels.datatables.infos', { offset_start: perPage * (currentPage - 1) + 1, offset_end: perPage * currentPage, total: totalRows }) }}</label>
      </b-col>
      <b-col md="4" class="mb-3">
        <b-form inline v-if="search" class="d-flex justify-content-end" @submit.prevent>
          <label class="mr-2">{{ $t('labels.datatables.search') }}</label>
          <b-form-input v-model="searchQuery" @input="debounceInput"></b-form-input>
        </b-form>
      </b-col>
    </b-row>
    <slot></slot>
    <b-row>
      <b-col md="4">
        <form class="form-inline" @submit.prevent="onBulkAction" v-if="actions">
          <div class="form-group">
            <b-form-select :options="actions" v-model="action" class="mr-1"></b-form-select>
            <b-button type="submit" variant="danger">{{ $t('labels.validate') }}</b-button>
          </div>
        </form>
      </b-col>
      <b-col md="4">
        <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" v-if="paging && totalRows > perPage"
                      class="justify-content-center" @input="onContextChanged"
        ></b-pagination>
      </b-col>
      <b-col md="4">
        <div v-if="exportData" class="d-flex justify-content-end">
          <b-button @click.prevent="onExportData"><i class="fe fe-download"></i> {{ $t('labels.export') }}</b-button>
        </div>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import axios from 'axios'
import _ from 'lodash'
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'

export default {
  props: {
    lengthChange: {
      type: Boolean,
      default: true
    },
    paging: {
      type: Boolean,
      default: true
    },
    infos: {
      type: Boolean,
      default: true
    },
    search: {
      type: Boolean,
      default: true
    },
    exportData: {
      type: Boolean,
      default: true
    },
    searchRoute: {
      type: String,
      default: null
    },
    deleteRoute: {
      type: String,
      default: null
    },
    actionRoute: {
      type: String,
      default: null
    },
    actions: {
      type: Object,
      default: () => {}
    },
    selected: {
      type: Array,
      default: () => []
    }
  },
  data () {
    return {
      currentPage: 1,
      perPage: 15,
      totalRows: 0,
      pageOptions: [ 5, 10, 15, 25, 50 ],
      searchQuery: null,
      action: null,
      client_name: null,
      invoice_status: null,
      technician: null,
      manager: null,
      valueOptions: [],
      managerOptions: [],
      statusOptions: [],
      ageingstatusOptions: [],
      ageingnameOptions: [],
      value_type: null,
      status_type: null,
      ageing_status_type: null,
      ageing_name_type: null,
      manager_type: null,
      jobcardstatus: null,
      config: {
        mode: 'range',
        defaultDate: [new Date()],
        wrap: true,
        altFormat: 'Y-m-d',
        altInput: true,
        dateFormat: 'Y-m-d'
      },
      date: null
    }
  },
  components: {
    flatPickr
  },
  watch: {
    actions: {
      handler () {
        if (this.actions) {
          this.action = Object.keys(this.actions)[0]
        }
      },
      immediate: true
    }
  },
  methods: {
    clearOptions () {
      this.valueOptions = []
    },
    debounceInput: _.debounce(function () {
      this.onContextChanged()
    }, 200),
    onContextChanged () {
      this.$emit('context-changed')
    },
    getvalue: _.debounce(function () {
      this.getAllValues()
    }, 200),
    getmanager: _.debounce(function () {
      this.getSearchManager()
    }, 200),
    getstatus: _.debounce(function () {
      this.getSearchStatus()
    }, 200),
    getageingstatus: _.debounce(function () {
      this.getAgeingStatus()
    }, 200),
    getageingname: _.debounce(function () {
      this.getAgeingName()
    }, 200),
    async getAllValues () {
      this.valueOptions = []
      let val = document.getElementById('value_type').value
      this.value_type = val
      // console.log(val, 'valuysss', this.value_type)
      let { data } = await axios.get(this.$app.route('admin.getSearchValue.getdata'), { params: { keyword: val } })
      // console.log('hey',data)
      this.valueOptions = data
    },
    async getSearchManager () {
      this.managerOptions = []
      let val = document.getElementById('manager_type').value
      this.manager_type = val
      // console.log(val, 'valuysss', this.manager_type)
      let { data } = await axios.get(this.$app.route('admin.getSearchManager.getdata'), { params: { keyword: val } })
      this.managerOptions = data
    },
    async getSearchStatus () {
      this.statusOptions = []
      let val = document.getElementById('status_type').value
      this.status_type = val
      // console.log(val, 'valuysss', this.value_type)
      let { data } = await axios.get(this.$app.route('admin.getSearchStatus.getdata'), { params: { keyword: val } })
      // console.log('hey',data)
      this.statusOptions = data
    },
    async getAgeingStatus () {
      this.ageingstatusOptions = []
      let val = document.getElementById('ageing_status_type').value
      this.ageing_status_type = val
      // console.log(val, 'valuysss', this.value_type)
      let { data } = await axios.get(this.$app.route('admin.getAgeingStatus.getdata'), { params: { keyword: val } })
      // console.log('hey',data)
      this.ageingstatusOptions = data
    },
    async getAgeingName () {
      this.ageingnameOptions = []
      let val = document.getElementById('ageing_name_type').value
      this.ageing_name_type = val
      let { data } = await axios.get(this.$app.route('admin.getAgeingName.getdata'), { params: { keyword: val } })
      this.ageingnameOptions = data
    },
    async loadData (sortBy, sortDesc) {
      try {
        let { data } = await axios.get(this.$app.route(this.searchRoute), {
          params: {
            page: this.currentPage,
            perPage: this.perPage,
            column: sortBy,
            direction: sortDesc ? 'desc' : 'asc',
            search: this.searchQuery,
            custom_search: {
              date: this.date,
              client_name: this.client_name,
              invoice_status: this.invoice_status,
              technician: this.technician,
              manager: this.manager,
              jobcardstatus: this.jobcardstatus
            }
          }
        })

        this.totalRows = data.total
        return data.data
      } catch (e) {
        this.$app.error(e)
        return []
      }
    },
    onExportData () {
      window.location = this.$app.route(this.searchRoute, {
        search: this.searchQuery,
        exportData: true
      })
    },
    async deleteRow (params) {
      let result = await window.swal({
        title: this.$t('labels.are_you_sure'),
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: this.$t('buttons.cancel'),
        confirmButtonColor: '#dd4b39',
        confirmButtonText: this.$t('buttons.delete')
      })

      if (result.value) {
        try {
          let { data } = await axios.delete(this.$app.route(this.deleteRoute, params))
          this.onContextChanged()
          this.$app.noty[data.status](data.message)
        } catch (e) {
          this.$app.error(e)
        }
      }
    },
    async onBulkAction () {
      let result = await window.swal({
        title: this.$t('labels.are_you_sure'),
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: this.$t('buttons.cancel'),
        confirmButtonColor: '#dd4b39',
        confirmButtonText: this.$t('buttons.confirm')
      })

      if (result.value) {
        try {
          let { data } = await axios.post(this.$app.route(this.actionRoute), {
            action: this.action,
            ids: this.selected
          })

          this.onContextChanged()
          this.$emit('update:selected', [])
          this.$app.noty[data.status](data.message)
        } catch (e) {
          this.$app.error(e)
        }
      }
    }
  }
}
</script>
