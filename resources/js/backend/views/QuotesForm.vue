<template>
  <div>
    <form @submit.prevent="onSubmit" class="quotes-form">
      <b-card>
        <h3 class="card-title" slot="header">{{ isNew ? $t('labels.backend.quotes.titles.create') : $t('labels.backend.quotes.titles.edit') }}</h3>
        <b-row>
          <b-col sm="6">
            <address class="form-group">
              <h5>Company Address:</h5>
              <p class="form-control-static"><span id="id_organization_address_heading" name="organization_address_heading">Shop No 2, 24B Devereaux Avenue</span></p>
              <p class="form-control-static">
                <span id="id_organization_address_business" name="organization_address_business">Judeko Trading and Projects</span>
              </p>
              <p class="form-control-static">
                <span id="id_organization_address_street" name="organization_address_street">Vincent, East London, 5217</span>
              </p>
              <p class="form-control-static">
                <span id="id_organization_address_town" name="organization_address_town">Reg. Number: 2015/345707/07</span>
              </p>
              <p class="form-control-static">
                <span id="id_organization_address_region" name="organization_address_region">Tax Number: 9217883199</span>
              </p>
              <p class="form-control-static">
                <span id="id_organization_address_postcode" name="organization_address_postcode">VAT Number: 4610275366</span>
              </p>
            </address>
            <div class="form-inline">
              <label class="control-label">Tel: </label>
              <span class="form-control-static">
              <span id="id_organization_tel_no" name="organization_tel_no">0430042314   Cell: 0735879015</span></span>
            </div>
            <div class="form-inline">
              <label class="control-label">Email: </label>
              <span class="form-control-static"> <span id="id_organization_email" name="organization_email">judekotrading@gmail.com</span></span>
            </div>
          </b-col>
          <b-col sm="6">
            <div id="org-img">
              <img class="thumbnail pull-right" src="https://app.quilder.com/media/orglogos/logo1_PRbyxru.png" alt="">
            </div>
          </b-col>
        </b-row>
        <hr>
        <!-- Client Details Section Starts -->
        <b-row>
          <b-col sm="6">
            <div class="well">
              <a href="#" class="btn btn-primary pull-right" data-toggle="modal" data-target="#searchAndAddContact" data-placement="left" onclick="">
                <span class="hidden-xs" @click="clientModal('Helllo')">Find Client</span>
                <span class="glyphicon glyphicon-search"></span>
              </a>
              <div class="clearfix"></div>

              <div id="contactFields">
                <b-col><h5>Quote For:</h5></b-col>
                <div class="form-inline">
                  <b-col sm="4">
                    <b-form-input
                      id="client_first_name"
                      name="client_first_name"
                      placeholder="Client first name"
                      v-model="model.client_first_name"
                      :state="state('client_first_name')"
                    ></b-form-input>
                  </b-col>
                  <b-col sm="4">
                    <b-form-input
                      id="client_last_name"
                      name="client_last_name"
                      placeholder="Client last name"
                      v-model="model.client_last_name"
                      :state="state('client_last_name')"
                    ></b-form-input>
                  </b-col>
                </div>
                <b-col sm="8">
                  <fieldset class="fieldset">
                    <legend>Address details</legend>
                    <b-form-input
                      id="client_address_business"
                      name="client_address_business"
                      placeholder="Client business"
                    ></b-form-input>
                    <b-form-input
                      id="client_address_street"
                      name="client_address_street"
                      placeholder="Street"
                    ></b-form-input>
                    <b-form-input
                      id="client_address_town"
                      name="client_address_town"
                      placeholder="Town"
                    ></b-form-input>
                    <b-form-input
                      id="client_address_region"
                      name="client_address_region"
                      placeholder="Region"
                    ></b-form-input>
                    <b-form-input
                      id="client_address_postcode"
                      name="client_address_postcode"
                      placeholder="Postcode"
                    ></b-form-input>
                  </fieldset>
                </b-col>
                <b-col sm="8">
                  <b-form-group>
                    <b-form-input
                      id="client_email"
                      name="client_email"
                      placeholder="Email"
                    ></b-form-input>
                  </b-form-group>
                </b-col>
              </div>
            </div>
          </b-col>
          <b-col sm="6">
            <div class="well">
              <b-form-group
                label="Quote Name"
                label-for="quotation_name"
                horizontal
                :label-cols="2"
                :feedback="feedback('quotation_name')"
              >
                <b-col sm="4">
                  <b-form-input
                    id="quotation_name"
                    name="quotation_name"
                    :placeholder="$t('validation.quotes.quotation_name')"
                    v-model="model.quotation_name"
                    :state="state('quotation_name')"
                  ></b-form-input>
                </b-col>
              </b-form-group>

              <b-form-group
                label="Quote Date"
                label-for="quotation_date"
                horizontal
                :label-cols="2"
                :feedback="feedback('quotation_date')"
              >
                <b-col sm="4">
                  <b-form-input
                    id="quotation_date"
                    name="quotation_date"
                    :value="today_date"
                    required
                    :placeholder="$t('validation.quotes.quotation_date')"
                    v-model="model.quotation_date"
                    readonly
                    :state="state('quotation_date')"
                  ></b-form-input>
                </b-col>
              </b-form-group>

              <b-form-group
                label="Quote Reference"
                label-for="quotation_number"
                horizontal
                :label-cols="2"
                :feedback="feedback('quotation_number')"
              >
                <b-col sm="4">
                  <b-form-input
                    id="quotation_number"
                    name="quotation_number"
                    required
                    :placeholder="$t('validation.quotes.quotation_number')"
                    v-model="model.quotation_number"
                    :state="state('quotation_number')"
                  ></b-form-input>
                </b-col>
              </b-form-group>
            </div>
          </b-col>
        </b-row>
        <!-- Client Details Section End -->
        <hr>
        <!-- Description Section -->
        <div class="well">
          <h5>Description of Work</h5>
          <b-form-textarea
            id="quotation_description"
            name="quotation_description"
            rows="6"
            placeholder="Fill in details of the job"
          ></b-form-textarea>
        </div>
        <!-- Description Section Ends -->
        <hr>
        <!-- Quote Details Section -->
        <div class="well">
          <h5>Quote Details
            <div class="pull-right">
              <b-btn variant="primary" title="Add a section to the job" v-b-modal.section-modal>
                <span class="hidden-xs">Add Section</span>
                <span class="glyphicon glyphicon-plus"></span>
              </b-btn>
              <!-- Add labour button -->
              <b-btn variant="primary" class="btn btn-primary" title="Add labour to the job" v-b-modal.labour-modal>
                <span class="hidden-xs">Add Labour</span>
                <span class="glyphicon glyphicon-plus"></span>
              </b-btn>
              <!-- Add job part button -->
              <b-btn variant="primary" title="Add a part to the job" v-b-modal.parts-modal>
                <span class="hidden-xs">Add Parts</span>
                <span class="glyphicon glyphicon-plus"></span>
              </b-btn>
            </div>
          </h5>
          <br>
          <div id="jobPartsTableDiv">
            <table class="table table-bordered table-striped table-hover" width="100%">
              <thead>
                <tr>
                  <th>Name</th>
                  <th style="text-align:right">Quantity</th>
                  <th>Net Amount</th>
                  <th style="text-align:right">Net Total</th>
                  <th style="text-align:right">Actions</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <!-- Quote Details Section Ends -->
        <hr>
        <!-- Bank Details & Total Amount Section  -->
        <b-row>
          <b-col sm="6">
            <div class="well">
              <div class="user-edit">
                <div class="form-group">
                  <h3 class="payment-terms">
                    <input class="form-control large-text" id="id_terms_heading" maxlength="255" name="terms_heading" type="text" value="Bank Details">
                  </h3>
                </div>
                <div class="form-group">
                  <textarea class="form-control" cols="40" id="id_terms" name="terms" placeholder="The details of your terms and conditions can be written here" rows="10">FNB Cheque Account: 62589280066</textarea>
                </div>
              </div>
            </div>
          </b-col>
          <b-col sm="6">
            <table id="table-invoice-total" class="form-inline table table-striped">
              <tbody>
                <tr>
                  <th class="vertical-th">Total Net Amount</th>
                  <td>
                    ZAR
                    <input class="form-control" id="id_total_net" name="total_net" readonly type="text" value="0.00">
                  </td>
                </tr>
                <tr>
                  <th class="vertical-th">Total VAT Amount</th>
                  <td>
                    ZAR
                    <input class="form-control pull-right" id="id_total_tax" name="total_tax" readonly type="text" value="0.00">
                  </td>
                </tr>
                <tr>
                  <th class="vertical-th">
                    Quote Total
                  </th>
                  <td>
                    ZAR
                    <input class="form-control pull-right" id="id_job_total" name="job_total" readonly type="text" value="0.00">
                  </td>
                </tr>
              </tbody>
            </table>
          </b-col>
          <b-col>
          </b-col>
        </b-row>
        <!-- Bank Details & Total Amount Section Ends -->
        <b-row slot="footer">
          <b-col md>
            <b-button to="/quotes" exact variant="danger" size="md">
              {{ $t('buttons.back') }}
            </b-button>
          </b-col>
          <b-col md>
            <b-dropdown right split :text="$t('buttons.quotes.save_and_publish')" class="float-right"
                        variant="success" size="sm" @click="onSubmit()"
                        :disabled="pending"
                        v-if="isNew || this.$app.user.can('edit quotes') || this.$app.user.can('edit own quotes')"
            >
            </b-dropdown>
          </b-col>
        </b-row>
        <!-- Footer Section Ends -->
      </b-card>
      <b-row>
        <!-- <b-col sm="8">
          <b-card>
            <b-form-group
              :label="$t('validation.quotes.quotation_name')"
              label-for="quotation_name"
              horizontal
              :label-cols="2"
              :feedback="feedback('quotation_name')"
            >
              <b-form-input
                id="quotation_name"
                name="quotation_name"
                :placeholder="$t('validation.quotes.quotation_name')"
                v-model="model.quotation_name"
                :state="state('quotation_name')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.travelling_time')"
              label-for="travelling_time"
              horizontal
              :label-cols="2"
              :feedback="feedback('travelling_time')"
            >
              <b-form-input
                id="travelling_time"
                name="travelling_time"
                :placeholder="$t('validation.quotes.travelling_time')"
                v-model="model.travelling_time"
                :state="state('travelling_time')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.travelling_km')"
              label-for="travelling_km"
              horizontal
              :label-cols="2"
              :feedback="feedback('travelling_km')"
            >
              <b-form-input
                id="travelling_km"
                name="travelling_km"
                :placeholder="$t('validation.quotes.travelling_km')"
                v-model="model.travelling_km"
                :state="state('travelling_km')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.vat_amount')"
              label-for="vat_amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('vat_amount')"
            >
              <b-form-input
                id="vat_amount"
                name="vat_amount"
                :placeholder="$t('validation.quotes.vat_amount')"
                v-model="model.vat_amount"
                :state="state('vat_amount')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.net_amount')"
              label-for="net_amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('net_amount')"
            >
              <b-form-input
                id="net_amount"
                name="net_amount"
                :placeholder="$t('validation.quotes.net_amount')"
                v-model="model.net_amount"
                :state="state('net_amount')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.total_amount')"
              label-for="total_amount"
              horizontal
              :label-cols="2"
              :feedback="feedback('total_amount')"
            >
              <b-form-input
                id="total_amount"
                name="total_amount"
                :placeholder="$t('validation.quotes.total_amount')"
                v-model="model.total_amount"
                :state="state('total_amount')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.labour_rates')"
              label-for="labour_rates"
              horizontal
              :label-cols="2"
            >
              <v-select
                id="labour_rates"
                name="labour_rates"
                v-model="model.labour_rates"
                :placeholder="$t('validation.quotes.labour_rates')"
                :options="labour_rates"
                :multiple="false"
                @search-change="getLabours"
              >
              </v-select>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.material_rates')"
              label-for="materials_rates"
              horizontal
              :label-cols="2"
            >
              <v-select
                id="materials_rates"
                name="materials_rates"
                v-model="model.materials_rates"
                :placeholder="$t('validation.quotes.material_rates')"
                :options="materials_rates"
                :multiple="false"
                @search-change="getMaterials"
              >
              </v-select>
            </b-form-group>

            <b-form-group
              :label="$t('validation.quotes.vat_rates')"
              label-for="vat_rates"
              horizontal
              :label-cols="2"
            >
              <v-select
                id="vat_rates"
                name="vat_rates"
                v-model="model.vat_rates"
                :placeholder="$t('validation.quotes.vat_rates')"
                :options="vat_rates"
                :multiple="false"
                @search-change="getVats"
              >
              </v-select>
            </b-form-group>

            <b-row slot="footer">
              <b-col md>
                <b-button to="/quotes" exact variant="danger" size="md">
                  {{ $t('buttons.back') }}
                </b-button>
              </b-col>
              <b-col md>
                <b-dropdown right split :text="$t('buttons.quotes.save_and_publish')" class="float-right"
                            variant="success" size="sm" @click="onSubmit()"
                            :disabled="pending"
                            v-if="isNew || this.$app.user.can('edit quotes') || this.$app.user.can('edit own quotes')"
                >
                </b-dropdown>
              </b-col>
            </b-row>
          </b-card>
        </b-col> -->
      </b-row>
    </form>

    <!-- Section Modal -->
    <b-modal id="section-modal" title="Add Section">
      <label>Name:</label>
      <b-form-input
        id="section_name"
        name="section_name"
      ></b-form-input>
    </b-modal>
    <!-- Labour Modal -->
    <b-modal id="labour-modal">
      <b-tabs>
        <b-tab title="Search Saved Labour" active>
          <form class="" role="search" action="" method="GET" id="labour-search-form">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search labour" id="txtSearchSavedLabour" name="search_term" style="width:100%;padding:6px 6px;" accept="">
              <div class="input-group-btn">
                <button id="btnSearchSavedLabour" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
              </div>
            </div>
            <br>
          </form>
        </b-tab>
        <b-tab title="Add Labour">
          <div class="modal-body">
            <div id="labourAddSectionDropdownDiv" aria-hidden="false"></div>
            <div id="labourAddDiv">
              <!-- Mustache template to edit labour parts -->
              <b-form-inline>
                <label class="mr-sm-2">Name:</label>
                <b-form-input
                  id="labour_part_name_edit"
                  name="labour_part_name_edit"
                ></b-form-input>
              </b-form-inline>
              <div id="labour_part_name_edit_error"></div>
              <b-form-inline>
                <label class="mr-sm-2">Labour quantity:</label>
                <b-form-input
                  id="labour_part_quantity_edit"
                  name="labour_part_quantity_edit"
                  type="number"
                ></b-form-input>
              </b-form-inline>
              <div id="labour_part_quantity_edit_error"></div>
              <b-form-inline>
                <label class="mr-sm-2">Labour Rate (ZAR):</label>
                <b-form-input
                  id="labour_part_sales_price_net_edit"
                  name="labour_part_sales_price_net_edit"
                  type="number"
                ></b-form-input>
                <div id="labour_part_sales_price_net_edit_error"></div>
              </b-form-inline>
              <br>
              <b-form-group>
                <label class="mr-sm-2"><b>Net Labour price (ZAR):</b></label>
                <span id="labour_part_total_sales_price_net_edit">0.00</span>
              </b-form-group>
              <b-form-group>
                <label class="mr-sm-2"><b>Vat Rate (%):</b></label>
                <span id="labour_part_tax_rate_edit">0.00</span>
              </b-form-group>
              <b-form-group>
                <label class="mr-sm-2"><b>Vat amount (ZAR):</b></label>
                <span id="labour_part_total_tax_edit">0.00</span>
              </b-form-group>
              <b-form-group>
                <label class="mr-sm-2"><b>Total (ZAR):</b></label>
                <span id="labour_part_total_edit">0.00</span>
              </b-form-group>
            </div>
          </div>
        </b-tab>
      </b-tabs>
    </b-modal>
    <!-- Parts Modal -->
    <b-modal id="parts-modal">
      <b-tabs>
        <b-tab title="Supplier Parts" active>
          <form class="" role="search" action="" method="GET" id="search-global-form">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search supplier parts" id="txtSearchSupplierParts" name="searchquery" style="width:100%;padding:6px 6px;" accept="">
              <div class="input-group-btn">
                <button id="btnSearchSupplierParts" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
              </div>
            </div>
            <br>
          </form>
          <div id="partGlobalSearchResultsDiv">
            <!-- part search results go here -->
          </div>
          <!-- Error when no keyword -->
          <div id="globalPartsSearchError" class="alert alert-danger fade in" style="display: none;">
            <strong>Search term required for supplier parts search</strong>
          </div>
        </b-tab>
        <b-tab title="Company Parts">
          <form class="" role="search" action="" method="GET" id="part-search-form">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search parts" id="txtSearchSavedParts" name="search_term" style="width:100%;padding:6px 6px;" accept="">
              <div class="input-group-btn">
                <button id="btnSearchSavedParts" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
              </div>
            </div>
            <br>
          </form>
          <div id="partSearchResultsDiv">
            <!-- part search results go here -->
          </div>
        </b-tab>
        <b-tab title="Add Parts">
          <div class="modal-body">
            <div id="partAddSectionDropdownDiv" aria-hidden="false"></div>
            <div id="partAddDiv">
              <!-- Mustache template to edit labour parts -->
              <b-form-inline>
                <label class="mr-sm-2">Name:</label>
                <b-form-input
                  id="job_part_name_edit"
                  name="job_part_name_edit"
                ></b-form-input>
              </b-form-inline>
              <div id="job_part_name_edit_error"></div>
              <b-form-inline>
                <label class="mr-sm-2">Quantity:</label>
                <b-form-input
                  id="job_part_quantity_edit"
                  name="job_part_quantity_edit"
                  type="number"
                ></b-form-input>
              </b-form-inline>
              <div id="job_part_quantity_edit_error"></div>
              <b-form-inline>
                <label class="mr-sm-2">Unit Sale Price (ZAR):</label>
                <b-form-input
                  id="job_part_sales_price_net_edit"
                  name="job_part_sales_price_net_edit"
                  type="number"
                ></b-form-input>
                <div id="job_part_sales_price_net_edit_error"></div>
              </b-form-inline>
              <br>
              <b-form-group>
                <label class="mr-sm-2"><b>Net Sale price (ZAR):</b></label>
                <span id="job_part_total_sales_price_net_edit">0.00</span>
              </b-form-group>
              <b-form-group>
                <label class="mr-sm-2"><b>Vat Rate (%):</b></label>
                <span id="job_part_tax_rate_edit">0.00</span>
              </b-form-group>
              <b-form-group>
                <label class="mr-sm-2"><b>Vat amount (ZAR):</b></label>
                <span id="job_part_total_tax_edit">0.00</span>
              </b-form-group>
              <b-form-group>
                <label class="mr-sm-2"><b>Total (ZAR):</b></label>
                <span id="job_part_total_edit">0.00</span>
              </b-form-group>
            </div>
          </div>
        </b-tab>
      </b-tabs>
    </b-modal>
  </div>
</template>

<script>
import axios from 'axios'
import form from '../mixins/form'
import moment from 'moment'

export default {
  name: 'QuotesForm',
  mixins: [form],
  data () {
    return {
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: true
      },
      modelName: 'quote',
      resourceRoute: 'quotes',
      listPath: '/quotes',
      labour_rates: [],
      materials_rates: [],
      vat_rates: [],
      today_date: null,
      model: {
        quotation_number: null,
        quotation_name: null,
        travelling_time: null,
        travelling_km: null,
        vat_amount: null,
        net_amount: null,
        total_amount: null,
        labour_rates: null,
        materials_rates: null,
        vat_rates: []
      }
    }
  },
  mounted: function () {
    var d = moment().format('ddd. DD, YYYY')
    this.today_date = d
  },
  created: function () {
    this.getLabours()
    this.getMaterials()
    this.getVats()
  },
  methods: {
    clientModal: function (message) {
      alert(message)
    },
    async getLabours () {
      let { data } = await axios.get(this.$app.route('admin.labours.getids'), {})

      this.labour_rates = data.ids
    },
    async getMaterials () {
      let { data } = await axios.get(this.$app.route('admin.materials.getids'), {})

      this.materials_rates = data.ids
    },
    async getVats () {
      let { data } = await axios.get(this.$app.route('admin.vats.getids'), {})

      this.vat_rates = data.ids
    }
  }
}
</script>
