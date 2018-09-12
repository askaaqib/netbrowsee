<template>
  <div>
    <form @submit.prevent="onSubmit">
      <b-row>
        <b-col xl="8">
          <b-card>
            <h3 class="card-title" slot="header">{{ isNew ? $t('labels.backend.projects.titles.create') : $t('labels.backend.projects.titles.edit') }}</h3>
            <b-form-group
              :label="$t('validation.attributes.name')"
              label-for="name"
              horizontal
              :label-cols="2"
              :feedback="feedback('name')"
            >
              <b-form-input
                id="name"
                name="name"
                required
                :placeholder="$t('validation.attributes.name')"
                v-model="model.name"
                :state="state('name')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.attributes.description')"
              label-for="description"
              horizontal
              :label-cols="2"
              :feedback="feedback('description')"
            >
              <b-form-textarea
                id="description"
                name="description"
                :rows="5"
                :placeholder="$t('validation.attributes.description')"
                v-model="model.description"
                :state="state('description')"
              ></b-form-textarea>
            </b-form-group>

            <b-row slot="footer">
              <b-col md>
                <b-button to="/projects" exact variant="danger" size="md">
                  {{ $t('buttons.back') }}
                </b-button>
              </b-col>
              <b-col md>
                <input name="status" type="hidden" value="publish">

                <b-dropdown right split :text="$t('buttons.projects.save_and_publish')" class="float-right"
                            variant="success" size="sm" @click="model.status = 'publish'; onSubmit()"
                            :disabled="pending"
                            v-if="isNew || this.$app.user.can('edit projects') || this.$app.user.can('edit own projects')"
                >
                  <b-dropdown-item @click="model.status = 'draft'; onSubmit()">{{ $t('buttons.projects.save_as_draft') }}
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
  name: 'ProjectForm',
  mixins: [form],
  data () {
    return {
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: true
      },
      modelName: 'project',
      resourceRoute: 'projects',
      listPath: '/projects',
      tags: [],
      model: {
        name: null,
        description: null
      }
    }
  }
}
</script>
