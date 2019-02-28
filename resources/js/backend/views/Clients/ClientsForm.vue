<template>
  <div>
    <form @submit.prevent="onSubmit">
      <b-row>
        <b-col xl="8">
          <b-card>
            <h3 class="card-title" slot="header">{{ isNew ? $t('labels.backend.clients.titles.create') : $t('labels.backend.clients.titles.edit') }}</h3>
            <b-form-group
              :label="$t('validation.clients.first_name')"
              label-for="first_name"
              horizontal
              :label-cols="2"
              :feedback="feedback('first_name')"
            >
              <b-form-input
                required
                :placeholder="$t('validation.clients.first_name')"
                v-model="model.first_name"
                :state="state('first_name')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.clients.last_name')"
              label-for="last_name"
              horizontal
              :label-cols="2"
              :feedback="feedback('last_name')"
            >
              <b-form-input
                required
                :placeholder="$t('validation.clients.last_name')"
                v-model="model.last_name"
                :state="state('last_name')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.clients.business_name')"
              label-for="business_name"
              horizontal
              :label-cols="2"
              :feedback="feedback('business_name')"
            >
              <b-form-input
                required
                :placeholder="$t('validation.clients.business_name')"
                v-model="model.business_name"
                :state="state('business_name')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.clients.email')"
              label-for="email"
              horizontal
              :label-cols="2"
              :feedback="feedback('email')"
            >
              <b-form-input
                required
                :placeholder="$t('validation.clients.email')"
                v-model="model.email"
                :state="state('email')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.clients.street')"
              label-for="street"
              horizontal
              :label-cols="2"
              :feedback="feedback('street')"
            >
              <b-form-input
                required
                :placeholder="$t('validation.clients.street')"
                v-model="model.street"
                :state="state('street')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.clients.town')"
              label-for="town"
              horizontal
              :label-cols="2"
              :feedback="feedback('town')"
            >
              <b-form-input
                required
                :placeholder="$t('validation.clients.town')"
                v-model="model.town"
                :state="state('town')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.clients.region')"
              label-for="region"
              horizontal
              :label-cols="2"
              :feedback="feedback('region')"
            >
              <b-form-input
                required
                :placeholder="$t('validation.clients.region')"
                v-model="model.region"
                :state="state('region')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.clients.postcode')"
              label-for="postcode"
              horizontal
              :label-cols="2"
              :feedback="feedback('postcode')"
            >
              <b-form-input
                required
                :placeholder="$t('validation.clients.postcode')"
                v-model="model.postcode"
                :state="state('postcode')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.clients.primary_phone')"
              label-for="primary_phone"
              horizontal
              :label-cols="2"
              :feedback="feedback('primary_phone')"
            >
              <b-form-input
                required
                :placeholder="$t('validation.clients.primary_phone')"
                v-model="model.primary_phone"
                :state="state('primary_phone')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.clients.secondary_phone')"
              label-for="secondary_phone"
              horizontal
              :label-cols="2"
              :feedback="feedback('secondary_phone')"
            >
              <b-form-input
                required
                :placeholder="$t('validation.clients.secondary_phone')"
                v-model="model.secondary_phone"
                :state="state('secondary_phone')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.clients.notes')"
              label-for="notes"
              horizontal
              :label-cols="2"
              :feedback="feedback('notes')"
            >
              <b-form-textarea
                required
                :placeholder="$t('validation.clients.notes')"
                v-model="model.notes"
                :state="state('notes')"
                rows="4"
              ></b-form-textarea>
            </b-form-group>

            <b-button
              class="float-right"
              variant="success"
              size="sm"
              @click="model.status = 'publish'; onSubmit()"
              :disabled="pending"
            > Save
            </b-button>
          </b-card>
        </b-col>
      </b-row>
    </form>
  </div>
</template>
<script>
// import axios from 'axios'
import form from '../../mixins/form'
export default {
  name: 'ClientsForm',
  mixins: [form],
  data () {
    return {
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: true
      },
      modelName: 'client',
      resourceRoute: 'clients',
      listPath: '/clients',
      tags: [],
      model: {
        first_name: null,
        last_name: null,
        business_name: null,
        email: null,
        street: null,
        town: null,
        region: null,
        postcode: null,
        primary_phone: null,
        secondary_phone: null,
        notes: null
      }
    }
  }
}
</script>
