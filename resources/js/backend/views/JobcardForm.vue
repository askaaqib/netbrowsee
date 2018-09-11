<template>
  <div>
    <form @submit.prevent="onSubmit">
      <b-row>
        <b-col xl="8">
          <b-card>
            <h3 class="card-title" slot="header">{{ isNew ? $t('labels.backend.jobcards.titles.create') : $t('labels.backend.jobcards.titles.edit') }}</h3>
            <b-form-group
              :label="$t('validation.jobcards.jobcard_num')"
              label-for="jobcard_num"
              horizontal
              :label-cols="2"
              :feedback="feedback('jobcard_num')"
            >
              <b-form-input
                id="jobcard_num"
                name="jobcard_num"
                required
                :placeholder="$t('validation.jobcards.jobcard_num')"
                v-model="model.jobcard_num"
                :state="state('jobcard_num')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.description')"
              label-for="description"
              horizontal
              :label-cols="2"
              :feedback="feedback('description')"
            >
              <b-form-textarea
                id="description"
                name="description"
                :rows="5"
                :placeholder="$t('validation.jobcards.description')"
                v-model="model.description"
                :state="state('description')"
              ></b-form-textarea>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.problem_type')"
              label-for="problem_type"
              horizontal
              :label-cols="2"
              :feedback="feedback('problem_type')"
            >
              <b-form-input
                id="problem_type"
                name="problem_type"
                required
                :placeholder="$t('validation.jobcards.problem_type')"
                v-model="model.problem_type"
                :state="state('problem_type')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.priority')"
              label-for="priority"
              horizontal
              :label-cols="2"
              :feedback="feedback('priority')"
            >
              <b-form-input
                id="priority"
                name="priority"
                required
                :placeholder="$t('validation.jobcards.priority')"
                v-model="model.priority"
                :state="state('priority')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.facility_name')"
              label-for="facility_name"
              horizontal
              :label-cols="2"
              :feedback="feedback('facility_name')"
            >
              <b-form-input
                id="facility_name"
                name="facility_name"
                required
                :placeholder="$t('validation.jobcards.facility_name')"
                v-model="model.facility_name"
                :state="state('facility_name')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.district')"
              label-for="district"
              horizontal
              :label-cols="2"
              :feedback="feedback('district')"
            >
              <b-form-input
                id="district"
                name="district"
                required
                :placeholder="$t('validation.jobcards.district')"
                v-model="model.district"
                :state="state('district')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.sub_district')"
              label-for="sub_district"
              horizontal
              :label-cols="2"
              :feedback="feedback('sub_district')"
            >
              <b-form-input
                id="sub_district"
                name="sub_district"
                required
                :placeholder="$t('validation.jobcards.sub_district')"
                v-model="model.sub_district"
                :state="state('sub_district')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.project_manager')"
              label-for="project_manager"
              horizontal
              :label-cols="2"
              :feedback="feedback('project_manager')"
            >
              <b-form-input
                id="project_manager"
                name="project_manager"
                required
                :placeholder="$t('validation.jobcards.project_manager')"
                v-model="model.project_manager"
                :state="state('project_manager')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.labour_paid')"
              label-for="labour_paid"
              horizontal
              :label-cols="2"
              :feedback="feedback('labour_paid')"
            >
              <b-form-input
                id="labour_paid"
                name="labour_paid"
                required
                :placeholder="$t('validation.jobcards.labour_paid')"
                v-model="model.labour_paid"
                :state="state('labour_paid')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.travelling_paid')"
              label-for="travelling_paid"
              horizontal
              :label-cols="2"
              :feedback="feedback('travelling_paid')"
            >
              <b-form-input
                id="travelling_paid"
                name="travelling_paid"
                required
                :placeholder="$t('validation.jobcards.travelling_paid')"
                v-model="model.travelling_paid"
                :state="state('travelling_paid')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.materials_paid')"
              label-for="materials_paid"
              horizontal
              :label-cols="2"
              :feedback="feedback('materials_paid')"
            >
              <b-form-input
                id="materials_paid"
                name="materials_paid"
                required
                :placeholder="$t('validation.jobcards.materials_paid')"
                v-model="model.materials_paid"
                :state="state('materials_paid')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.quoted_amount')"
              label-for="quoted_amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('quoted_amount')"
            >
              <b-form-input
                id="quoted_amount"
                name="quoted_amount"
                required
                :placeholder="$t('validation.jobcards.quoted_amount')"
                v-model="model.quoted_amount"
                :state="state('quoted_amount')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.status')"
              label-for="status"
              horizontal
              :label-cols="2"
              :feedback="feedback('status')"
            >
              <b-form-input
                id="status"
                name="status"
                required
                :placeholder="$t('validation.jobcards.status')"
                v-model="model.status"
                :state="state('status')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.assigned_to')"
              label-for="assigned_to"
              horizontal
              :label-cols="2"
              :feedback="feedback('assigned_to')"
            >
              <b-form-input
                id="assigned_to"
                name="assigned_to"
                required
                :placeholder="$t('validation.jobcards.assigned_to')"
                v-model="model.assigned_to"
                :state="state('assigned_to')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.before_pictures')"
              label-for="before_pictures"
              horizontal
              :label-cols="2"
              :feedback="feedback('before_pictures')"
            >
              <b-form-input
                id="before_pictures"
                name="before_pictures"
                required
                :placeholder="$t('validation.jobcards.before_pictures')"
                v-model="model.before_pictures"
                :state="state('before_pictures')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.jobcards.during_after_pictures')"
              label-for="during_after_pictures"
              horizontal
              :label-cols="2"
              :feedback="feedback('during_after_pictures')"
            >
              <b-form-input
                id="during_after_pictures"
                name="during_after_pictures"
                required
                :placeholder="$t('validation.jobcards.during_after_pictures')"
                v-model="model.during_after_pictures"
                :state="state('during_after_pictures')"
              ></b-form-input>
            </b-form-group>

            <b-row slot="footer">
              <b-col md>
                <b-button to="/jobcards" exact variant="danger" size="md">
                  {{ $t('buttons.back') }}
                </b-button>
              </b-col>
              <b-col md>
                <input name="status" type="hidden" value="publish">

                <!-- <b-dropdown right :text="$t('buttons.jobcards.save_and_publish')" class="float-right"
                            variant="success" size="md" @click="model.status = 'publish'; onSubmit()"
                            :disabled="pending"
                            v-if="isNew || this.$app.user.can('edit jobcards') || this.$app.user.can('edit own jobcards')"
                >
                </b-dropdown> -->
                <b-dropdown right split :text="$t('buttons.jobcards.save_and_publish')" class="float-right"
                            variant="success" size="sm" @click="model.status = 'publish'; onSubmit()"
                            :disabled="pending"
                            v-if="isNew || this.$app.user.can('edit jobcards') || this.$app.user.can('edit own jobcards')"
                >
                  <b-dropdown-item @click="model.status = 'draft'; onSubmit()">{{ $t('buttons.jobcards.save_as_draft') }}
                  </b-dropdown-item>
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
import form from '../mixins/form'

export default {
  name: 'PostForm',
  mixins: [form],
  data () {
    return {
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: true
      },
      modelName: 'jobcard',
      resourceRoute: 'jobcards',
      listPath: '/jobcards',
      tags: [],
      model: {
        jobcard_num: null,
        description: null,
        problem_type: null,
        priority: null,
        facility_name: null,
        district: null,
        sub_district: null,
        project_manager: null,
        labour_paid: null,
        materials_paid: null,
        quoted_amount: null,
        status: null,
        assigned_to: null,
        before_pictures: null,
        during_after_pictures: null
      }
    }
  }
}
</script>
