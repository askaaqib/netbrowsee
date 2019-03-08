<template>
  <div>
    <form @submit.prevent="onSubmit">
      <b-row>
        <b-col xl="8">
          <b-card>
            <h3 class="card-title" slot="header">{{ isNew ? $t('labels.backend.reports.titles.create') : $t('labels.backend.reports.titles.edit') }}</h3>
            <b-form-group
              :label="$t('validation.reports.description')"
              label-for="description"
              horizontal
              :label-cols="2"
              :feedback="feedback('description')"
            >
              <b-form-textarea
                id="description"
                name="description"
                :rows="5"
                :placeholder="$t('validation.reports.description')"
                v-model="model.description"
                :state="state('description')"
              ></b-form-textarea>
            </b-form-group>

            <b-form-group
              :label="$t('validation.reports.status')"
              label-for="status"
              horizontal
              :label-cols="2"
              :feedback="feedback('status')"
            >
              <b-form-input
                id="status"
                name="status"
                required
                :placeholder="$t('validation.reports.status')"
                v-model="model.status"
                :state="state('status')"
              ></b-form-input>

            </b-form-group>

            <b-form-group
              :label="$t('validation.reports.expenses')"
              label-for="expenses"
              horizontal
              :label-cols="2"
              :feedback="feedback('expenses')"
            >
              <b-form-input
                id="expenses"
                name="expenses"
                required
                :placeholder="$t('validation.reports.expenses')"
                v-model="model.expenses"
                :state="state('expenses')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.reports.amount')"
              label-for="amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('amount')"
            >
              <b-form-input
                id="amount"
                name="amount"
                required
                :placeholder="$t('validation.reports.amount')"
                v-model="model.amount"
                :state="state('amount')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.reports.vat_collected')"
              label-for="vat_collected"
              horizontal
              :label-cols="2"
              :feedback="feedback('vat_collected')"
            >
              <b-form-input
                id="vat_collected"
                name="vat_collected"
                required
                :placeholder="$t('validation.reports.vat_collected')"
                v-model="model.vat_collected"
                :state="state('vat_collected')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.reports.profit_loss')"
              label-for="profit_loss"
              horizontal
              :label-cols="2"
              :feedback="feedback('profit_loss')"
            >
              <b-form-input
                id="profit_loss"
                name="profit_loss"
                required
                :placeholder="$t('validation.reports.profit_loss')"
                v-model="model.profit_loss"
                :state="state('profit_loss')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.reports.jobcard')"
              label-for="jobcard_id"
              horizontal
              :label-cols="2"
              :feedback="feedback('jobcard_id')"
            >
              <v-select
                id="jobcard_id"
                name="jobcard_id"
                v-model="model.jobcard_id"
                :options="jobcards"
                placeholder="Select Jobcard"
                label="jobcard_num"
                @search-change="getJobcards"
              >
              </v-select>
            </b-form-group>

            <b-row slot="footer">
              <b-col md>
                <b-button to="/reports" exact variant="danger" size="md">
                  {{ $t('buttons.back') }}
                </b-button>
              </b-col>
              <b-col md>
                <b-dropdown right split :text="$t('buttons.reports.save_and_publish')" class="float-right"
                            variant="success" size="sm" @click="onSubmit()"
                            :disabled="pending"
                            v-if="isNew || this.$app.user.can('edit reports') || this.$app.user.can('edit own reports')"
                >
                </b-dropdown>
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
  name: 'ReportsForm',
  mixins: [form],
  data () {
    return {
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: true
      },
      modelName: 'report',
      resourceRoute: 'reports',
      listPath: '/reports',
      jobcards: [],
      model: {
        description: null,
        status: null,
        expenses: null,
        amount: null,
        vat_collected: null,
        profit_loss: null,
        jobcard_id: null
      }
    }
  },
  created: function () {
    this.getJobcards()
  },
  methods: {
    async getJobcards () {
      let { data } = await axios.get(this.$app.route('admin.jobcards.getdata'), {})

      this.jobcards = data
    }
  }
}
</script>
