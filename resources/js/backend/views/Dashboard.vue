<template>
  <div>
    <b-row>
      <b-col xl="12">
        <b-row v-if="this.$app.user.can('view users')">
          <b-col sm>
            <b-card text-variant="white" class="unallocated-jobs text-center">
              <b-row>
                <b-col class="icon-shield">
                  <i class="fe fe-shield-off"></i>
                </b-col>
              </b-row>
              <h4 class="mb-0">{{ Unallocatedjobcards ? Unallocatedjobcards : '0' }}</h4>
              <p>{{ $t('labels.backend.dashboard.unallocated_jobcards') }}</p>
            </b-card>
          </b-col>
          <b-col sm>
            <b-card class="in-progress-jobs text-center" text-variant="white">
              <b-row>
                <b-col class="icon-shield">
                  <i class="fe fe-repeat"></i>
                </b-col>
              </b-row>
              <h4 class="mb-0">{{ Progressjobcards ? Progressjobcards : '0' }}</h4>
              <p>{{ $t('labels.backend.dashboard.jobcards_in_progress') }}</p>
            </b-card>
          </b-col>
          <b-col sm>
            <b-card class="completed-jobs text-center" text-variant="white">
               <b-row>
                <b-col class="icon-shield">
                  <i class="fe fe-check"></i>
                </b-col>
              </b-row>
              <h4 class="mb-0">{{ Completedjobcards ? Completedjobcards : '0' }}</h4>
              <p>{{ $t('labels.backend.dashboard.completed_jobcards') }}</p>
            </b-card>
          </b-col>
          <b-col sm v-if="this.$app.user.can('view users')">
            <b-card class="quoted-jobs text-center" text-variant="white">
               <b-row>
                <b-col class="icon-shield">
                  <i class="fe fe-inbox"></i>
                </b-col>
              </b-row>
              <h4 class="mb-0">{{ Quotedjobcards ? Quotedjobcards : '0' }}</h4>
              <p>{{ $t('labels.backend.dashboard.quoted_jobcards') }}</p>
            </b-card>
          </b-col>
          <b-col sm v-if="this.$app.user.can('view form_submissions')">
            <b-card class="invoiced-jobs text-center" text-variant="white">
              <b-row>
                <b-col class="icon-shield">
                  <i class="fe fe-map"></i>
                </b-col>
              </b-row>
              <h4 class="mb-0">{{ Invoicedjobcards ? Invoicedjobcards : '0' }}</h4>
              <p>{{ $t('labels.backend.dashboard.invoiced_jobcards') }}</p>
            </b-card>
          </b-col>
          <b-col sm v-if="this.$app.user.can('view users')">
            <b-card class="quoted-amount text-center" text-variant="white">
               <b-row>
                <b-col class="icon-shield">
                  <i class="fe fe-tag"></i>
                </b-col>
              </b-row>
              <h4 class="mb-0">{{ QuotedAmount ? QuotedAmount : '0' }}</h4>
              <p>{{ $t('labels.backend.dashboard.quoted_amount') }}</p>
            </b-card>
          </b-col>
          <b-col sm v-if="this.$app.user.can('view form_submissions')">
            <b-card class="invoiced-amount text-center" text-variant="white">
              <b-row>
                <b-col class="icon-shield">
                  <i class="fe fe-dollar-sign"></i>
                </b-col>
              </b-row>
              <h4 class="mb-0">{{ InvoiceAmount ? InvoiceAmount : '0' }}</h4>
              <p>{{ $t('labels.backend.dashboard.invoiced_amount') }}</p>
            </b-card>
          </b-col>
        </b-row>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Dashboard',
  data () {
    return {
      Completedjobcards: null,
      Quotedjobcards: null,
      Invoicedjobcards: null,
      Unallocatedjobcards: null,
      Progressjobcards: null,
      QuotedAmount: null,
      InvoiceAmount: null,
      post_fields: {
        title: { label: this.$t('validation.attributes.title') },
        status: { label: this.$t('validation.attributes.status') },
        pinned: { label: this.$t('validation.attributes.pinned') },
        summary: { label: this.$t('validation.attributes.summary') },
        published_at: { label: this.$t('validation.attributes.published_at'), 'class': 'text-center' }
      },
      posts: []
    }
  },
  async created () {
    this.completeJobcard()
    this.quotedJobcard()
    this.invoicedJobcard()
    this.unallocatedJobcard()
    this.progressJobcard()
    this.quotedamount()
    this.invoiceamount()

    // if (this.$app.user.can('view own posts')) {
    //   let { data } = await axios.get(this.$app.route('admin.posts.latest'))
    //   this.posts = data
    // }
  },
  methods: {
    async completeJobcard () {
      await axios
        .get(this.$app.route('admin.dashboard.completeJobcard'))
        .then((result) => {
          if (result.data.status === 200) {
            this.Completedjobcards = result.data.completed_jobcards
          }
        })
    },

    async quotedJobcard () {
      await axios
        .get(this.$app.route('admin.dashboard.quotedJobcard'))
        .then((result) => {
          if (result.data.status === 200) {
            this.Quotedjobcards = result.data.quoted_jobcards
          }
        })
    },
    async invoicedJobcard () {
      await axios
        .get(this.$app.route('admin.dashboard.invoicedJobcard'))
        .then((result) => {
          if (result.data.status === 200) {
            this.Invoicedjobcards = result.data.invoiced_jobcards
          }
        })
    },

    async unallocatedJobcard () {
      await axios
        .get(this.$app.route('admin.dashboard.unallocatedJobcard'))
        .then((result) => {
          if (result.data.status === 200) {
            this.Unallocatedjobcards = result.data.unallocated_jobcards
          }
        })
    },
    async progressJobcard () {
      await axios
        .get(this.$app.route('admin.dashboard.progressJobcard'))
        .then((result) => {
          if (result.data.status === 200) {
            this.Progressjobcards = result.data.progress_jobcards
          }
        })
    },

    async quotedamount () {
      await axios
        .get(this.$app.route('admin.dashboard.quotedamount'))
        .then((result) => {
          if (result.data.status === 200) {
            this.QuotedAmount = result.data.quoted_amountSum
          }
        })
    },

    async invoiceamount () {
      await axios
        .get(this.$app.route('admin.dashboard.invoiceamount'))
        .then((result) => {
          if (result.data.status === 200) {
            this.InvoiceAmount = result.data.invoice_amount
          }
        })
    }

  }
}
</script>
