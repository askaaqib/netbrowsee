<template>
  <div>
    <form @submit.prevent="onSubmit" class="quotes-form">
      <b-card>
        <h3 class="card-title" slot="header">{{ isNew ? $t('labels.backend.quotes.titles.create') : $t('labels.backend.quotes.titles.edit') }}</h3>
        <b-row>
          <b-col sm="6">
            <address class="form-group">
              <h5 v-if="settings.company_address">Company Address:</h5>
              <p>{{ settings.company_address }}</p>
            </address>
          </b-col>
          <b-col sm="6">
            <div id="org-img">
              <img v-if="settings.company_logo" class="thumbnail pull-right card-img-top" :src="'/uploads/'+ settings.company_logo" alt="">
            </div>
          </b-col>
        </b-row>
        <hr>
        <!-- Client Details Section Starts -->
        <b-row>
          <b-col sm="6">
            <div class="well">
              <b-btn variant="primary" class="pull-right search-modal-btn" title="Find Client" v-b-modal.client-modal>
                <span class="hidden-xs">Find Client<i class="fe fe-search"></i></span>
              </b-btn>
              <div class="clearfix"></div>

              <div id="contactFields">
                <b-col><h5>Quote For:</h5></b-col>
                <div class="form-inline">
                  <b-col sm="4">
                    <b-form-input
                      id="client_name"
                      name="client_name"
                      placeholder="Client name"
                      v-model="model.client_name"
                      :state="state('client_name')"
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
                      v-model="client_email"
                    ></b-form-input>
                  </b-form-group>
                </b-col>
              </div>
            </div>
          </b-col>
          <b-col sm="6">
            <div class="well">
              <b-form-group
                label="Select Jobcard"
                label-for="jobcard_no"
                horizontal
                :label-cols="2"
                :feedback="feedback('jobcard_no')"
              >
                <b-col sm="4">
                  <v-select
                    id="jobcard_no"
                    name="jobcard_no"
                    v-model="model.jobcards"
                    placeholder="Please Select Jobcard"
                    :options="jobcards"
                    :multiple="false"
                    label="jobcard_num"
                  >
                  </v-select>
                </b-col>
              </b-form-group>

              <b-form-group
                label="Select Project"
                label-for="project_id"
                horizontal
                :label-cols="2"
                :feedback="feedback('project_id')"
              >
                <b-col sm="4">
                  <v-select
                    id="project_id"
                    name="project_id"
                    v-model="model.project"
                    placeholder="Please Select Project"
                    :options="projects"
                    :multiple="false"
                    label="name"
                    :on-change="getProjectId"
                  >
                  </v-select>
                </b-col>
              </b-form-group>

              <b-form-group
                v-if="model.project"
                label="Select Project Manager"
                label-for="project_manager_id"
                horizontal
                :label-cols="2"
                :feedback="feedback('project_manager_id')"
              >
                <b-col sm="4">
                  <v-select
                    id="project_manager_id"
                    name="project_manager_id"
                    v-model="model.project_manager"
                    placeholder="Please Select Project Number"
                    :options="project_managers"
                    :multiple="false"
                    label="name"
                  >
                  </v-select>
                </b-col>
              </b-form-group>

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
                    :value="model.quotation_name"
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
                    placeholder="Quote Reference"
                    v-model="model.quotation_number"
                    readonly
                    :state="state('quotation_number')"
                    :value="quotation_reference"
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
            v-model="model.quotes_description"
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
            <table ref="detailsTable" class="table table-bordered table-striped table-hover" width="100%">
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
                <tr v-for="(row, index) in rows" :key="index" track-by="index">
                  <template v-if="row.section">
                    <!-- <td>{{ index }}</td> -->
                    <td colspan="4"><h3>{{ row.section }}</h3></td>
                    <td>
                      <div class="pull-right">
                        <button type="button" class="btn btn-danger btn-sm" @click="removeRow(index)">Delete</button>
                        <button type="button" class="btn btn-secondary btn-sm" @click="editRowSection(index)">Edit</button>
                      </div>
                    </td>
                  </template>
                  <template v-else-if="row.labour">
                    <td>
                      {{ row.name }}
                    </td>
                    <td>
                      {{ row.quantity }}
                    </td>
                    <td>
                      {{ row.net_amount }}
                    </td>
                    <td>
                      {{ row.net_total }}
                    </td>
                    <td>
                      <div class="pull-right">
                        <button type="button" class="btn btn-danger btn-sm" @click="removeRow(index)">Delete</button>
                        <button type="button" class="btn btn-secondary btn-sm" @click="editRowLabour(index)">Edit</button>
                      </div>
                    </td>
                  </template>
                  <template v-else-if="row.parts">
                    <td>
                      {{ row.name }}
                    </td>
                    <td>
                      {{ row.quantity }}
                    </td>
                    <td>
                      {{ row.net_amount }}
                    </td>
                    <td>
                      {{ row.net_total }}
                    </td>
                    <td>
                      <div class="pull-right">
                        <button type="button" class="btn btn-danger btn-sm" @click="removeRow(index)">Delete</button>
                        <button type="button" class="btn btn-secondary btn-sm" @click="editRowParts(index)">Edit</button>
                      </div>
                    </td>
                  </template>
                </tr>
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
                    <input class="form-control large-text" readonly id="id_terms_heading" maxlength="255" name="terms_heading" type="text" value="Bank Details">
                  </h3>
                </div>
                <div class="form-group">
                  <textarea class="form-control" cols="40" v-model="settings.bank_account" id="id_terms" name="terms" placeholder="The details of your terms and conditions can be written here" rows="10"></textarea>
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
                    <input class="form-control" id="id_total_net" name="total_net" readonly type="text" v-model="quotes.quotesNetTotal">
                  </td>
                </tr>
                <tr>
                  <th class="vertical-th">Total VAT Amount</th>
                  <td>
                    ZAR
                    <input class="form-control pull-right" id="id_total_tax" name="total_tax" readonly type="text" v-model="quotes.quotesVatTotal">
                  </td>
                </tr>
                <tr>
                  <th class="vertical-th">
                    Quote Total
                  </th>
                  <td>
                    ZAR
                    <input class="form-control pull-right" id="id_job_total" name="job_total" readonly type="text" v-model="quotes.quotesTotal">
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
    </form>
    <!-- Find Client Modal -->
    <b-modal ref="clientSearchModalRef" id="client-modal" hide-footer title="Find Client" size="lg">
      <b-input-group>
        <b-form-input
          id="search_client"
          name="search_client"
          v-model="client_search.search_client"
          placeholder="Search clients"
        ></b-form-input>
        <b-input-group-append>
          <b-btn variant="success" @click="searchClient"><i class="fe fe-search fe-lg"></i></b-btn>
        </b-input-group-append>
      </b-input-group>
      <div class="modal-body search-content">
        <ul v-if="!client_search.client_info_get.error" class="row grid">
          <li v-for="(client,index) in client_search.client_info_get" :key="client.id" class="col-sm-6">
            <div class="user-list">
              <input type="hidden" :class="'part_json_' +client.id" v-model="client_search.client_searched_data">
              <h4>{{ client.name }}</h4>
              <p>{{ client.email }}</p>
              <b-btn variant="outline-primary" size="sm" class="pull-right select-client" @click="selectSearchedClient(index)">Select<i class="fe fe-check"></i></b-btn>
              <div class="clearfix"></div>
            </div>
          </li>
        </ul>
        <div v-if="client_search.client_info_get.error" class="mt-2">
          <b-alert show variant="danger">{{ client_search.client_info_get.error }}</b-alert>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" @click="hideModal('clientSearchModalRef')">Cancel</button>
      </div>
    </b-modal>
    <!-- Section Modal -->
    <b-modal ref="sectionModalRef" id="section-modal" hide-footer title="Add Section">
      <label>Name:</label>
      <b-form-input
        id="section_name"
        name="section_name"
        v-model="section_name"
      ></b-form-input>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" @click="hideModal('sectionModalRef')">Cancel</button>
        <button type="button" class="btn btn-secondary" @click="AddSection">Save</button>
      </div>
    </b-modal>
    <!-- Update Section Modal -->
    <b-modal ref="updateSectionModalRef" id="update-section-modal" hide-footer title="Edit Section">
      <label>Name:</label>
      <b-form-input
        id="section_name_edit"
        name="section_name_edit"
        v-model="section_name_edit"
      ></b-form-input>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" @click="hideModal('updateSectionModalRef')">Cancel</button>
        <button type="button" class="btn btn-secondary" @click="UpdateSection(section_edit_index)">Save</button>
      </div>
    </b-modal>
    <!-- Create Labour Modal -->
    <b-modal ref="AddLabourSection" id="labour-modal" hide-footer>
      <b-tabs v-model="labourTabIndex">
        <b-tab ref="searchSavedLabour" title="Search Saved Labour" active>
          <b-input-group>
            <b-form-input
              id="search_labour"
              name="search_labour"
              v-model="labour_search.search_labour"
              placeholder="Search labour"
            ></b-form-input>
            <b-input-group-append>
              <b-btn variant="success" @click="searchSavedLabour"><i class="fe fe-search"></i></b-btn>
            </b-input-group-append>
          </b-input-group>
          <div class="model-body search-content">
            <ul v-if="!labour_search.labour_info_get.error" class="grid">
              <li v-for="(labourr,index) in labour_search.labour_info_get" :key="labourr.id">
                <div class="part-list">
                  <input type="hidden" :class="'part_json_' +labourr.id" v-model="labour_search.labour_searched_data">
                  <h4 class="part-name">{{ labourr.name }}</h4>
                  <div v-if="labourr.description" class="description">
                    <h5>Description:</h5>
                    <p>{{ labourr.description }} </p>
                  </div>
                  <b-btn variant="outline-primary" size="sm" class="pull-right" @click="selectSearchedLabour(index)">Select<i class="fe fe-check"></i></b-btn>
                  <div class="total-price">
                    <h4 class="h-total-price">Total Price:</h4>
                    <span class="labour-total-price">ZAR{{ labourr.rate }}</span>
                  </div>
                </div>
              </li>
            </ul>
            <div v-if="labour_search.labour_info_get.error" class="mt-2">
              <b-alert show variant="danger">{{ labour_search.labour_info_get.error }}</b-alert>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="hideModal('addLabourSection')">Cancel</button>
          </div>
        </b-tab>
        <b-tab ref="addLabourTab" title="Add Labour">
          <div class="modal-body">
            <div id="labourAddSectionDropdownDiv" aria-hidden="false"></div>
            <div id="labourAddDiv">
              <!-- Mustache template to edit labour parts -->
              <b-form-group v-if="sectionStatus">
                <label class="mr-sm-2">Section:</label>
                <b-form-select
                  id="labour_part_name_edit"
                  name="labour_part_name_edit"
                  v-model="section_select"
                >
                  <option value="null">
                    No Section
                  </option>
                  <template v-for="(row,index) in rows">
                    <option v-if="row.section != null" :key="index" :value="index">
                      {{ row.section }}
                    </option>
                  </template>
                </b-form-select>
              </b-form-group>
              <b-form-group>
                <label class="mr-sm-2">Name:</label>
                <b-form-input
                  id="labour_part_name_edit"
                  name="labour_part_name_edit"
                  v-model="labour.labour_name"
                ></b-form-input>
              </b-form-group>
              <div id="labour_part_name_edit_error"></div>
              <b-form-group>
                <label class="mr-sm-2">Labour quantity:</label>
                <b-form-input
                  id="labour_part_quantity_edit"
                  name="labour_part_quantity_edit"
                  type="number"
                  v-model="labour.labour_quantity"
                  @change="LabourRateChange"
                ></b-form-input>
              </b-form-group>
              <div id="labour_part_quantity_edit_error"></div>
              <b-form-group>
                <label class="mr-sm-2">Labour Rate (ZAR):</label>
                <b-form-input
                  id="labour_part_sales_price_net_edit"
                  name="labour_part_sales_price_net_edit"
                  type="number"
                  v-model="labour.labour_rate_zar"
                  @change="LabourRateChange"
                ></b-form-input>
                <div id="labour_part_sales_price_net_edit_error"></div>
              </b-form-group>
              <br>
              <b-form-group>
                <label class="mr-sm-2"><b>Net Labour price (ZAR):</b></label>
                <span id="labour_part_total_sales_price_net_edit">{{ labour.net_labour_price_zar }}</span>
              </b-form-group>
              <b-form-group>
                <label class="mr-sm-2"><b>Vat Rate (%):</b></label>
                <span id="labour_part_tax_rate_edit">{{ labour.labour_vat_rate }}</span>
              </b-form-group>
              <b-form-group>
                <label class="mr-sm-2"><b>Vat amount (ZAR):</b></label>
                <span id="labour_part_total_tax_edit">{{ labour.labour_vat_amount_zar }}</span>
              </b-form-group>
              <b-form-group>
                <label class="mr-sm-2"><b>Total (ZAR):</b></label>
                <span id="labour_part_total_edit">{{ labour.labour_total_zar }}</span>
              </b-form-group>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="hideModal('addLabourSection')">Cancel</button>
            <button type="button" class="btn btn-secondary" @click="AddLabour">Add</button>
          </div>
        </b-tab>
      </b-tabs>
    </b-modal>
    <!-- Update Labour Modal -->
    <b-modal ref="updateLabourSection" id="update-labour-modal" hide-footer title="Edit Labour">
      <div class="modal-body">
        <div id="labourAddSectionDropdownDiv" aria-hidden="false"></div>
        <div id="labourAddDiv">
          <!-- Mustache template to edit labour parts -->
          <b-form-group v-if="sectionStatus">
            <label class="mr-sm-2">Section:</label>
            <b-form-select
              id="labour_part_name_edit"
              name="labour_part_name_edit"
              v-model="labour_edit.section_select_edit"
            >
              <option value="null">
                No Section
              </option>
              <template v-for="(row,index) in rows">
                <option v-if="row.section != null" :key="index" :value="index">
                  {{ row.section }}
                </option>
              </template>
            </b-form-select>
          </b-form-group>
          <b-form-group>
            <label class="mr-sm-2">Name:</label>
            <b-form-input
              id="labour_part_name_edit"
              name="labour_part_name_edit"
              v-model="labour_edit.labour_name"
            ></b-form-input>
          </b-form-group>
          <div id="labour_part_name_edit_error"></div>
          <b-form-group>
            <label class="mr-sm-2">Labour quantity:</label>
            <b-form-input
              id="labour_part_quantity_edit"
              name="labour_part_quantity_edit"
              type="number"
              v-model="labour_edit.labour_quantity"
              @change="LabourRateChange"
            ></b-form-input>
          </b-form-group>
          <div id="labour_part_quantity_edit_error"></div>
          <b-form-group>
            <label class="mr-sm-2">Labour Rate (ZAR):</label>
            <b-form-input
              id="labour_part_sales_price_net_edit"
              name="labour_part_sales_price_net_edit"
              type="number"
              v-model="labour_edit.labour_rate_zar"
              @change="LabourRateChange"
            ></b-form-input>
            <div id="labour_part_sales_price_net_edit_error"></div>
          </b-form-group>
          <br>
          <b-form-group>
            <label class="mr-sm-2"><b>Net Labour price (ZAR):</b></label>
            <span id="labour_part_total_sales_price_net_edit">{{ labour_edit.net_labour_price_zar }}</span>
          </b-form-group>
          <b-form-group>
            <label class="mr-sm-2"><b>Vat Rate (%):</b></label>
            <span id="labour_part_tax_rate_edit">{{ labour_edit.labour_vat_rate }}</span>
          </b-form-group>
          <b-form-group>
            <label class="mr-sm-2"><b>Vat amount (ZAR):</b></label>
            <span id="labour_part_total_tax_edit">{{ labour_edit.labour_vat_amount_zar }}</span>
          </b-form-group>
          <b-form-group>
            <label class="mr-sm-2"><b>Total (ZAR):</b></label>
            <span id="labour_part_total_edit">{{ labour_edit.labour_total_zar }}</span>
          </b-form-group>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" @click="hideModal('updateLabourSection')">Cancel</button>
        <button type="button" class="btn btn-secondary" @click="UpdateLabour(labour_edit_index)">Update</button>
      </div>
    </b-modal>
    <!-- Parts Modal -------- PARTS SECTION -----------  -->
    <b-modal ref="AddPartsSection" hide-footer id="parts-modal">
      <b-tabs>
        <b-tab title="Supplier Parts" active>
          <div class="model-body">
            <b-input-group>
              <b-form-input
                id="search_supplier_parts"
                name="search_supplier_parts"
                v-model="parts.search_supplier_parts"
                placeholder="Search supplier parts"
              ></b-form-input>
              <b-input-group-append>
                <b-btn variant="success" @click="searchSupplierParts"><i class="fe fe-search"></i></b-btn>
              </b-input-group-append>
            </b-input-group>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="hideModal('addPartsSection')">Cancel</button>
          </div>
        </b-tab>
        <b-tab title="Company Parts">
          <div class="model-body">
            <b-input-group>
              <b-form-input
                id="search_company_parts"
                name="search_company_parts"
                v-model="parts.search_company_parts"
                placeholder="Search company parts"
              ></b-form-input>
              <b-input-group-append>
                <b-btn variant="success" @click="searchCompanyParts"><i class="fe fe-search"></i></b-btn>
              </b-input-group-append>
            </b-input-group>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="hideModal('addPartsSection')">Cancel</button>
          </div>
        </b-tab>
        <b-tab title="Add Parts">
          <div class="modal-body">
            <div id="partsAddSectionDropdownDiv" aria-hidden="false"></div>
            <div id="partsAddDiv">
              <!-- Mustache template to edit suplier/company parts -->
              <b-form-group v-if="sectionStatus">
                <label class="mr-sm-2">Section:</label>
                <b-form-select
                  id="parts_part_name_edit"
                  name="parts_part_name_edit"
                  v-model="section_select"
                >
                  <option value="null">
                    No Section
                  </option>
                  <template v-for="(row,index) in rows">
                    <option v-if="row.section != null" :key="index" :value="index">
                      {{ row.section }}
                    </option>
                  </template>
                </b-form-select>
              </b-form-group>
              <b-form-group>
                <label class="mr-sm-2">Name:</label>
                <b-form-input
                  id="parts_part_name_edit"
                  name="parts_part_name_edit"
                  v-model="parts.parts_name"
                ></b-form-input>
              </b-form-group>
              <div id="parts_part_name_edit_error"></div>
              <b-form-group>
                <label class="mr-sm-2">Quantity:</label>
                <b-form-input
                  id="parts_part_quantity_edit"
                  name="parts_part_quantity_edit"
                  type="number"
                  v-model="parts.parts_quantity"
                  @change="PartsRateChange"
                ></b-form-input>
              </b-form-group>
              <div id="parts_part_quantity_edit_error"></div>
              <b-form-group>
                <label class="mr-sm-2">Unit Sale Price (ZAR):</label>
                <b-form-input
                  id="parts_part_sales_price_net_edit"
                  name="parts_part_sales_price_net_edit"
                  type="number"
                  v-model="parts.parts_rate_zar"
                  @change="PartsRateChange"
                ></b-form-input>
                <div id="parts_part_sales_price_net_edit_error"></div>
              </b-form-group>
              <br>
              <b-form-group>
                <label class="mr-sm-2"><b>Net Sale price (ZAR):</b></label>
                <span id="parts_part_total_sales_price_net_edit">{{ parts.net_parts_price_zar }}</span>
              </b-form-group>
              <b-form-group>
                <label class="mr-sm-2"><b>Vat Rate (%):</b></label>
                <span id="parts_part_tax_rate_edit">{{ parts.parts_vat_rate }}</span>
              </b-form-group>
              <b-form-group>
                <label class="mr-sm-2"><b>Vat amount (ZAR):</b></label>
                <span id="parts_part_total_tax_edit">{{ parts.parts_vat_amount_zar }}</span>
              </b-form-group>
              <b-form-group>
                <label class="mr-sm-2"><b>Total (ZAR):</b></label>
                <span id="parts_part_total_edit">{{ parts.parts_total_zar }}</span>
              </b-form-group>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="hideModal('addPartsSection')">Cancel</button>
            <button type="button" class="btn btn-secondary" @click="AddParts">Add</button>
          </div>
        </b-tab>
      </b-tabs>
    </b-modal>
    <!-- Update Parts Modal -->
    <b-modal ref="updatePartsSection" id="update-parts-modal" hide-footer title="Edit Parts">
      <div class="modal-body">
        <div id="partsEditSectionDropdownDiv" aria-hidden="false"></div>
        <div id="partsEditDiv">
          <!-- Mustache template to edit parts -->
          <b-form-group v-if="sectionStatus">
            <label class="mr-sm-2">Section:</label>
            <b-form-select
              id="parts_part_name_edit"
              name="parts_part_name_edit"
              v-model="parts_edit.section_select_edit"
            >
              <option value="null">
                No Section
              </option>
              <template v-for="(row,index) in rows">
                <option v-if="row.section != null" :key="index" :value="index">
                  {{ row.section }}
                </option>
              </template>
            </b-form-select>
          </b-form-group>
          <b-form-group>
            <label class="mr-sm-2">Name:</label>
            <b-form-input
              id="parts_part_name_edit"
              name="parts_part_name_edit"
              v-model="parts_edit.parts_name"
            ></b-form-input>
          </b-form-group>
          <div id="parts_part_name_edit_error"></div>
          <b-form-group>
            <label class="mr-sm-2">Quantity:</label>
            <b-form-input
              id="parts_part_quantity_edit"
              name="parts_part_quantity_edit"
              type="number"
              v-model="parts_edit.parts_quantity"
              @change="PartsRateChange"
            ></b-form-input>
          </b-form-group>
          <div id="parts_part_quantity_edit_error"></div>
          <b-form-group>
            <label class="mr-sm-2">Unit Sale Price (ZAR):</label>
            <b-form-input
              id="parts_part_sales_price_net_edit"
              name="parts_part_sales_price_net_edit"
              type="number"
              v-model="parts_edit.parts_rate_zar"
              @change="PartsRateChange"
            ></b-form-input>
            <div id="parts_part_sales_price_net_edit_error"></div>
          </b-form-group>
          <br>
          <b-form-group>
            <label class="mr-sm-2"><b>Net sale price (ZAR):</b></label>
            <span id="parts_part_total_sales_price_net_edit">{{ parts_edit.net_parts_price_zar }}</span>
          </b-form-group>
          <b-form-group>
            <label class="mr-sm-2"><b>Vat Rate (%):</b></label>
            <span id="parts_part_tax_rate_edit">{{ parts_edit.parts_vat_rate }}</span>
          </b-form-group>
          <b-form-group>
            <label class="mr-sm-2"><b>Vat amount (ZAR):</b></label>
            <span id="parts_part_total_tax_edit">{{ parts_edit.parts_vat_amount_zar }}</span>
          </b-form-group>
          <b-form-group>
            <label class="mr-sm-2"><b>Total (ZAR):</b></label>
            <span id="parts_part_total_edit">{{ parts_edit.parts_total_zar }}</span>
          </b-form-group>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" @click="hideModal('updatePartsSection')">Cancel</button>
        <button type="button" class="btn btn-secondary" @click="UpdateParts(parts_edit_index)">Update</button>
      </div>
    </b-modal>
  </div>
</template>

<script>
import axios from 'axios'
import form from '../mixins/form'
import moment from 'moment'
import bModalDirective from 'bootstrap-vue/es/directives/modal/modal'
import swal from 'sweetalert2'

export default {
  name: 'QuotesForm',
  directives: { 'b-modal': bModalDirective },
  mixins: [form],
  data () {
    return {
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: true
      },
      rows: [
        // initial data
      ],
      modelName: 'quote',
      resourceRoute: 'quotes',
      listPath: '/quotes',
      labour_rates: [],
      materials_rates: [],
      vat_rates: [],
      jobcards: [],
      projects: [],
      project_managers: [],
      today_date: null,
      section_name: '',
      section_name_edit: '',
      section_edit_index: null,
      labour_edit_index: null,
      parts_edit_index: null,
      section_select: 'null',
      jobcards_facility: [],
      last_quote_ref: null,
      quotation_reference: null,
      labourTabIndex: 0,
      sectionStatus: null,
      client_email: null,
      client_search: {
        search_client: null,
        client_info_get: [],
        client_searched_data: []
      },
      labour: {
        labour_name: '',
        labour_quantity: 0,
        labour_rate_zar: 0,
        net_labour_price_zar: 0.00,
        labour_vat_rate: 15.00,
        labour_vat_amount_zar: 0.00,
        labour_total_zar: 0.00
      },
      labour_edit: {
        section_select_edit: '',
        labour_name: '',
        labour_quantity: 0,
        labour_rate_zar: 0,
        net_labour_price_zar: 0.00,
        labour_vat_rate: 15.00,
        labour_vat_amount_zar: 0.00,
        labour_total_zar: 0.00
      },
      labour_search: {
        search_labour: '',
        labour_info_get: [],
        labour_searched_data: []
      },
      parts: {
        parts_name: '',
        parts_quantity: 0,
        parts_rate_zar: 0,
        net_parts_price_zar: 0.00,
        parts_vat_rate: 15.00,
        parts_vat_amount_zar: 0.00,
        parts_total_zar: 0.00
      },
      parts_edit: {
        section_select_edit: '',
        parts_name: '',
        parts_quantity: 0,
        parts_rate_zar: 0,
        net_parts_price_zar: 0.00,
        parts_vat_rate: 15.00,
        parts_vat_amount_zar: 0.00,
        parts_total_zar: 0.00
      },
      settings: {
        company_address: null,
        quote_vat: null,
        company_name: null,
        quote_ref_start: null,
        bank_account: null,
        company_logo: null
      },
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
        vat_rates: [],
        jobcards: null,
        project: null,
        project_manager: null,
        general_vat_rate: 15.00,
        client_name: null,
        quotes_description: null
      },
      quotes: {
        quotesNetTotal: 0.00,
        quotesVatTotal: 0.00,
        quotesTotal: 0.00
      }
    }
  },
  computed: {
    randomNumber: function () {
      return 'QU-001'
    }
  },
  watch: {
    'model.project': function (val, oldval) {
      if (val) {
        this.getProjectManagers(val.id)
        if (oldval) {
          if (val.name !== oldval.name) {
            this.model.project_manager = ' '
          }
        }
      }
    },
    'model.jobcards': function (val) {
      if (val) {
        this.getJobcardsFacility(val.id)
      } else {
        this.model.quotation_name = ''
      }
    },
    'jobcards_facility': function (val) {
      if (val) {
        this.model.quotation_name = val.jobcard_num + '' + val.facility_name
      }
    },
    'last_quote_ref': function (val) {
      if (val) {
        this.quotation_reference = parseInt(val) + 1
      } else {
        // check value quote ref start from settings
        if (this.settings.quote_ref_start) {
          this.quotation_reference = this.settings.quote_ref_start + 1
        } else {
          alert('Please Add Quote Reference Start From Settings')
          this.$router.push('/settings')
        }
      }
    },
    'rows': function (val) {
      this.quotes.quotesNetTotal = 0
      this.quotes.quotesVatTotal = 0
      var saveVal = 'empty'
      val.forEach((item, index) => {
        if (item.labour || item.parts) {
          this.quotes.quotesNetTotal += item.net_total
          this.quotes.quotesVatTotal += this.settings.quote_vat * item.net_total / 100
        }
        if (item.section) {
          saveVal = index
          this.sectionStatus = 1
        } else {
          if (saveVal !== 'empty') {
            item.parent_section = saveVal
          }
          if (saveVal === 'empty') {
            this.sectionStatus = null
          }
        }
      })

      if (val.length === 0) {
        this.sectionStatus = null
      }
      this.quotes.quotesTotal = this.quotes.quotesNetTotal + this.quotes.quotesVatTotal
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
    this.getJobcards()
    this.getProjects()
    this.getSettings()
    this.getQuotesReference()
  },
  methods: {
    getProjectId: function () {
      alert('coming here')
    },
    addRow: function (index) {
      try {
        this.rows.splice(index + 1, 0, {})
      } catch (e) {
        // console.log(e)
      }
    },
    editRowSection: function (key) {
      this.section_name_edit = this.rows[key].section
      this.section_edit_index = key
      this.showModal('updateSectionModalRef')
    },
    removeRow: function (index) {
      if (this.rows[index].section) {
        var noChildSection = 0
        this.rows.map((currentValue, index1, arr) => {
          // Check if Section have values in it
          if (!currentValue.section && currentValue.parent_section === index) {
            swal({
              title: 'Delete Section',
              text: 'Deleting a section will delete all parts within that section. Are you sure?',
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#ccc',
              confirmButtonText: 'Delete Section'
            }).then((result) => {
              if (result.value) {
                for (var i = this.rows.length - 1; i >= index; i--) {
                  if ('parent_section' in this.rows[i]) {
                    if (this.rows[i].parent_section === index) {
                      this.rows.splice(i, 1)
                    }
                  }
                }
                this.rows.splice(index, 1)
              } else {
                return false
              }
            })
            noChildSection = 1
          }
        })
        if (noChildSection === 0) {
          this.rows.splice(index, 1)
        }
      } else {
        this.rows.splice(index, 1)
      }
    },
    searchClient: function () {
      this.searchClientClick(this.client_search.search_client)
    },
    searchSavedLabour: function () {
      this.searchLabour(this.labour_search.search_labour)
    },
    selectSearchedClient: function (index) {
      this.model.client_name = this.client_search.client_info_get[index].name
      this.client_email = this.client_search.client_info_get[index].email
      this.hideModal('clientSearchModalRef')
    },
    AddSection: function () {
      if (!this.section_name) {
        alert('please enter section name')
        return false
      }
      this.rows.push({ section: this.section_name })
      this.$refs.sectionModalRef.hide()
      this.section_name = ''
      // this.sectionStatus = 1
    },
    UpdateSection: function (index) {
      this.rows[index].section = this.section_name_edit
      this.hideModal('updateSectionModalRef')
    },
    LabourRateChange: function () {
      this.labour.net_labour_price_zar = parseInt(this.labour.labour_quantity) * parseInt(this.labour.labour_rate_zar)
      this.labour.labour_vat_amount_zar = (this.labour.labour_vat_rate * this.labour.net_labour_price_zar) / 100
      this.labour.labour_total_zar = this.labour.net_labour_price_zar + this.labour.labour_vat_amount_zar
      // On Edit LabourRate Change
      this.labour_edit.net_labour_price_zar = parseInt(this.labour_edit.labour_quantity) * parseInt(this.labour_edit.labour_rate_zar)
      this.labour_edit.labour_vat_amount_zar = (this.labour_edit.labour_vat_rate * this.labour_edit.net_labour_price_zar) / 100
      this.labour_edit.labour_total_zar = this.labour_edit.net_labour_price_zar + this.labour_edit.labour_vat_amount_zar
    },
    AddLabour: function () {
      if (this.section_select !== 'null') {
        this.rows.splice(this.section_select + 1, 0, { labour: this.labour.labour_name, parent_section: this.section_select, name: this.labour.labour_name, quantity: this.labour.labour_quantity, net_amount: this.labour.labour_rate_zar, net_total: this.labour.net_labour_price_zar, labour_vat_rate: this.labour.labour_vat_rate, labour_vat_amount_zar: this.labour.labour_vat_amount_zar, labour_total_zar: this.labour.labour_total_zar })
      } else {
        this.rows.unshift({ labour: this.labour.labour_name, parent_section: this.section_select, name: this.labour.labour_name, quantity: this.labour.labour_quantity, net_amount: this.labour.labour_rate_zar, net_total: this.labour.net_labour_price_zar, labour_vat_rate: this.labour.labour_vat_rate, labour_vat_amount_zar: this.labour.labour_vat_amount_zar, labour_total_zar: this.labour.labour_total_zar })
      }
      this.hideModal('addLabourSection')
    },
    editRowLabour: function (key) {
      this.labour_edit.labour_name = this.rows[key].name
      this.labour_edit.labour_quantity = this.rows[key].quantity
      this.labour_edit.labour_rate_zar = this.rows[key].net_amount
      this.labour_edit.net_labour_price_zar = this.rows[key].net_total
      this.labour_edit.labour_vat_rate = this.rows[key].labour_vat_rate
      this.labour_edit.labour_vat_amount_zar = this.rows[key].labour_vat_amount_zar
      this.labour_edit.labour_total_zar = this.rows[key].labour_total_zar
      this.labour_edit.section_select_edit = this.rows[key].parent_section
      this.labour_edit_index = key
      this.showModal('updateLabourSection')
    },
    UpdateLabour: function (index) {
      this.rows[index].parent_section = this.labour_edit.section_select_edit
      this.rows[index].name = this.labour_edit.labour_name
      this.rows[index].quantity = this.labour_edit.labour_quantity
      this.rows[index].net_amount = this.labour_edit.labour_rate_zar
      this.rows[index].net_total = this.labour_edit.net_labour_price_zar
      this.rows[index].labour_vat_rate = this.labour_edit.labour_vat_rate
      this.rows[index].labour_vat_amount_zar = this.labour_edit.labour_vat_amount_zar
      this.rows[index].labour_total_zar = this.labour_edit.labour_total_zar
      var updateRow = this.rows[index]
      this.rows.splice(index, 1)
      this.rows.splice(updateRow.parent_section + 1, 0, updateRow)
      this.hideModal('updateLabourSection')
      var previousRows = this.rows
      this.rows = []
      this.rows = previousRows
    },
    PartsRateChange: function () {
      this.parts.net_parts_price_zar = parseInt(this.parts.parts_quantity) * parseInt(this.parts.parts_rate_zar)
      this.parts.parts_vat_amount_zar = (this.parts.parts_vat_rate * this.parts.net_parts_price_zar) / 100
      this.parts.parts_total_zar = this.parts.net_parts_price_zar + this.parts.parts_vat_amount_zar
      // On Edit PartsRate Change
      this.parts_edit.net_parts_price_zar = parseInt(this.parts_edit.parts_quantity) * parseInt(this.parts_edit.parts_rate_zar)
      this.parts_edit.parts_vat_amount_zar = (this.parts_edit.parts_vat_rate * this.parts_edit.net_parts_price_zar) / 100
      this.parts_edit.parts_total_zar = this.parts_edit.net_parts_price_zar + this.parts_edit.parts_vat_amount_zar
    },
    AddParts: function () {
      if (this.section_select !== 'null') {
        this.rows.splice(this.section_select + 1, 0, { parts: this.parts.parts_name, parent_section: this.section_select, name: this.parts.parts_name, quantity: this.parts.parts_quantity, net_amount: this.parts.parts_rate_zar, net_total: this.parts.net_parts_price_zar, parts_vat_rate: this.parts.parts_vat_rate, parts_vat_amount_zar: this.parts.parts_vat_amount_zar, parts_total_zar: this.parts.parts_total_zar })
      } else {
        this.rows.splice(0, 0, { parts: this.parts.parts_name, parent_section: this.section_select, name: this.parts.parts_name, quantity: this.parts.parts_quantity, net_amount: this.parts.parts_rate_zar, net_total: this.parts.net_parts_price_zar, parts_vat_rate: this.parts.parts_vat_rate, parts_vat_amount_zar: this.parts.parts_vat_amount_zar, parts_total_zar: this.parts.parts_total_zar })
      }
      this.hideModal('addPartsSection')
    },
    editRowParts: function (key) {
      this.parts_edit.parts_name = this.rows[key].name
      this.parts_edit.parts_quantity = this.rows[key].quantity
      this.parts_edit.parts_rate_zar = this.rows[key].net_amount
      this.parts_edit.net_parts_price_zar = this.rows[key].net_total
      this.parts_edit.parts_vat_rate = this.rows[key].parts_vat_rate
      this.parts_edit.parts_vat_amount_zar = this.rows[key].parts_vat_amount_zar
      this.parts_edit.parts_total_zar = this.rows[key].parts_total_zar
      this.parts_edit.section_select_edit = this.rows[key].parent_section
      this.parts_edit_index = key
      this.showModal('updatePartsSection')
    },
    UpdateParts: function (index) {
      this.rows[index].parent_section = this.parts_edit.section_select_edit
      this.rows[index].name = this.parts_edit.parts_name
      this.rows[index].quantity = this.parts_edit.parts_quantity
      this.rows[index].net_amount = this.parts_edit.parts_rate_zar
      this.rows[index].net_total = this.parts_edit.net_parts_price_zar
      this.rows[index].parts_vat_rate = this.parts_edit.parts_vat_rate
      this.rows[index].parts_vat_amount_zar = this.parts_edit.parts_vat_amount_zar
      this.rows[index].parts_total_zar = this.parts_edit.parts_total_zar
      var updateRow = this.rows[index]
      this.rows.splice(index, 1)
      this.rows.splice(updateRow.parent_section + 1, 0, updateRow)
      this.hideModal('updatePartsSection')
      var previousRows = this.rows
      this.rows = []
      this.rows = previousRows
    },
    selectSearchedLabour: function (index) {
      this.labourTabIndex += 1
      this.labour.labour_name = this.labour_search.labour_info_get[index].name
      this.labour.labour_quantity = 1
      this.labour.labour_rate_zar = this.labour_search.labour_info_get[index].rate
      this.labour.labour_vat_rate = this.settings.quote_vat

      this.labour.net_labour_price_zar = parseInt(this.labour.labour_quantity) * parseInt(this.labour.labour_rate_zar)
      this.labour.labour_vat_amount_zar = (this.labour.labour_vat_rate * this.labour.net_labour_price_zar) / 100
      this.labour.labour_total_zar = this.labour.net_labour_price_zar + this.labour.labour_vat_amount_zar
    },
    searchSupplierParts: function () {
      // console.log('Search Supplier Parts')
    },
    searchCompanyParts: function () {
      // console.log('Search Company Parts')
    },
    async searchClientClick ($q) {
      let { data } = await axios.get(this.$app.route('admin.clients.searchclients'), { params: { q: $q } })
      if (data.length > 0) {
        this.client_search.client_info_get = data
        this.client_search.client_searched_data = { id: data.id, name: data.name, email: data.email }
      } else {
        this.client_search.client_info_get = { error: 'No Client Found' }
      }
    },
    async searchLabour ($q) {
      let { data } = await axios.get(this.$app.route('admin.labours.searchlabour'), { params: { q: $q } })
      if (data.length > 0) {
        this.labour_search.labour_info_get = data
        this.labour_search.labour_searched_data = { id: data.id, name: data.name, description: data.description, vat_rate: 15, rate: data.rate }
      } else {
        this.labour_search.labour_info_get = { error: 'No Labour Found' }
      }
    },
    async getLabours ($q = 0) {
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
    },
    async getJobcards () {
      let { data } = await axios.get(this.$app.route('admin.jobcards.getdata'), {})

      this.jobcards = data
    },
    async getProjects () {
      let { data } = await axios.get(this.$app.route('admin.projects.getdata'), {})

      this.projects = data
    },
    async getProjectManagers ($id = 0) {
      let { data } = await axios.get(this.$app.route('admin.project_managers.getdata'), { params: { id: $id } })

      this.project_managers = data
    },
    async getJobcardsFacility ($id = 0) {
      let { data } = await axios.get(this.$app.route('admin.jobcards.getdata'), { params: { id: $id } })
      if (data) {
        this.jobcards_facility = data[0]
      } else {
        this.jobcards_facility = ''
      }
    },
    async getSettings () {
      let { data } = await axios.get(this.$app.route('admin.settings.getdata'), {})
      this.settings.company_name = data.company_name
      this.settings.company_address = data.company_address
      this.settings.company_logo = data.company_logo
      this.settings.bank_account = data.bank_account
      this.settings.quote_ref_start = data.quote_ref_start
      this.settings.quote_vat = data.quote_vat
      // Assign the general/settings vat rate value to labour and parts vat rate
      if (data.quote_vat) {
        this.labour.labour_vat_rate = data.quote_vat
        this.labour_edit.labour_vat_rate = data.quote_vat
        this.parts.parts_vat_rate = data.quote_vat
        this.parts_edit.parts_vat_rate = data.quote_vat
      }
    },
    async getQuotesReference () {
      let { data } = await axios.get(this.$app.route('admin.quotations.getreference'), {})
      this.last_quote_ref = data.quotation_number
    },
    showModal (ModalRef) {
      if (ModalRef === 'updateSectionModalRef') {
        this.$refs.updateSectionModalRef.show()
      }
      if (ModalRef === 'updateLabourSection') {
        this.$refs.updateLabourSection.show()
      }
      if (ModalRef === 'updatePartsSection') {
        this.$refs.updatePartsSection.show()
      }
    },
    hideModal (ModalRef) {
      if (ModalRef === 'sectionModalRef') {
        this.$refs.sectionModalRef.hide()
        this.emptySectionText()
      }
      if (ModalRef === 'updateSectionModalRef') {
        this.$refs.updateSectionModalRef.hide()
      }
      if (ModalRef === 'addLabourSection') {
        this.$refs.AddLabourSection.hide()
        this.emptyLabourText()
      }
      if (ModalRef === 'updateLabourSection') {
        this.$refs.updateLabourSection.hide()
      }
      if (ModalRef === 'addPartsSection') {
        this.$refs.AddPartsSection.hide()
        this.emptyPartsText()
      }
      if (ModalRef === 'updatePartsSection') {
        this.$refs.updatePartsSection.hide()
      }
      if (ModalRef === 'clientSearchModalRef') {
        this.$refs.clientSearchModalRef.hide()
      }
    },
    emptySectionText: function () {
      this.section_name = ''
    },
    emptyLabourText: function () {
      this.labour.labour_name = ''
      this.labour.labour_quantity = 0
      this.labour.labour_rate_zar = 0
      this.labour.labour_vat_rate = 15.00
      this.labour.labour_vat_amount_zar = 0.00
      this.labour.net_labour_price_zar = 0.00
      this.labour.labour_total_zar = 0.00
    },
    emptyPartsText: function () {
      this.parts.parts_name = ''
      this.parts.parts_quantity = 0
      this.parts.parts_rate_zar = 0.00
      this.parts.parts_vat_rate = 15.00
      this.parts.parts_vat_amount_zar = 0.00
      this.parts.net_parts_price_zar = 0.00
      this.parts.parts_total_zar = 0.00
    }
  }
}
</script>
