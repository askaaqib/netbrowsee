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
    </b-card>
  </div>
</template>

<script>

export default {
  name: 'JobcardList',
  data () {
    return {
      JobcardList: 'Something'
    }
  }
}
</script>
