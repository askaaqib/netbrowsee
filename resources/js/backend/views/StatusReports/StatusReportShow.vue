<template>
  <div>
    <form>
      <b-row class="justify-content-center">
        <b-col xl="10">
          <b-card>
            <h3>{{ isNew ? $t('labels.backend.contact.titles.main') : $t('labels.backend.contact.titles.main') }}</h3>
            <template>
              <b-form-group
                :label="$t('validation.attributes.subject')"
                label-for="subject"
                horizontal
                :label-cols="3"
              >
                <span>{{ model.subject }}</span>
              </b-form-group>
            </template>
            <template> 
              <b-form-group
                :label="$t('validation.attributes.message')"
                label-for="message"
                horizontal
                :label-cols="3"
              >
                <span>{{ model.message }}</span>
              </b-form-group>
            </template>
             
            <b-row id="hideback" slot="footer">
              <b-col md>
                <b-button to="/contact" exact variant="danger" size="md">
                  {{ $t('buttons.back') }}
                </b-button>
              </b-col>
            </b-row>
          </b-card>
        </b-col>
      </b-row>
    </form>
  </div>
</template>
<script>
import axios from 'axios'
import form from '../../mixins/form'
export default {
  name: 'StatusReportShow',
  mixins: [form],
  data() {
    return {
      // roles: [],
      // current_role: null,
      modelName: 'StatusReport',
      resourceRoute: 'statusreport',
      listPath: '/statusreport',
      fields: [
        { key: 'subject', label: 'Subject' },
        { key: 'message', label: 'Message' }
      ],
      model: {
        subject: null,
        message: null
      }
    }
  },
  async created() {},
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
