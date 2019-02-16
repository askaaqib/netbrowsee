<template>
  <div id="quotes-view" class="container">
    <div class="quotes-form action texty" id="fontset">
      <b-card>
        <h3 class="card-title" slot="header">Completed Quote</h3>
        <b-row>
          <b-col class="col-md-12">
            <b-btn class="btn-show pull-right" id="hideprint" variant="secondary" @click="printquotes()">Print<i class="fe fe-printer fe-lg"></i></b-btn>
            <b-btn class="btn-show pull-right" id="hidedownload" variant="secondary">Download Pdf<i class="fe fe-file fe-lg"></i></b-btn>
          </b-col>
        </b-row>
        <!-- ViewPort  Starts -->
        <div id="viewport" class="table-responsive">
          <b-row>
            <b-col sm="6">
              <address class="form-group">
                <h5 v-if="model.company_address">Company Address:</h5>
                <!-- <p>{{ model.company_address }}</p> -->
                <p v-html="settings.company_address"></p>
              </address>
            </b-col>
            <b-col sm="6">
              <div id="org-img">
                <img v-if="model.company_logo" class="thumbnail pull-right card-img-top" :src="'/uploads/'+ model.company_logo" alt="">
              </div>
            </b-col>
          </b-row>
          <hr>
          <!-- Client Details Section Starts -->
          <b-row>
            <b-col sm="6">
              <b-col sm="8">
                <div class="well" id="manage">
                  <address class="form-group">
                    <label class="control-label"><b>Quote for:</b></label>
                    <p class="form-control-static">{{ model.client_email }}</p>
                  </address>
                <!-- /right -->
                </div>
              </b-col>
            </b-col>
            <b-col sm="6">
              <div class="well" id="right">
                <div class="align-right">
                  <div class="form-group">
                    <label class="control-label"><b>Quote name: </b></label> <span class="form-control-static">{{ model.quotation_name }}</span>
                  </div>
                  <div class="form-group" data-original-title="" title="">
                    <label class="control-label"><b>Quote date: </b></label> <span class="form-control-static">{{ model.quotation_date }}</span>
                  </div>
                  <div class="form-group" data-original-title="" title="">
                    <label class="control-label"><b>Quote reference: </b></label> <span class="form-control-static">QU-{{ model.quotation_number }}</span>
                  </div>
                </div>
              <!-- /right -->
              </div>
            </b-col>
          </b-row>
          <!-- Client Details Section End -->
          <hr>
          <!-- Description Section -->
          <h3 style="color:#303030">Description Of Work</h3>
          <p>{{ model.quotation_description }}</p>
          <!-- Description Section Ends -->
          <!-- Quote Details Section -->
          <br>
          <div id="jobPartsTableDivShow">
            <table ref="detailsTable" id="sideline" class="table table-striped table-hover" width="100%">
              <thead class="thead-show">
                <tr>
                  <th>Name</th>
                  <th>Quantity</th>
                  <th>Net Amount</th>
                  <th>Net Total</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(row, index) in rows" :key="index" track-by="index">
                  <template v-if="row.section">
                    <!-- <td>{{ index }}</td> -->
                    <td colspan="4"><h3>{{ row.section }}</h3></td>
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
                  </template>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- Quote Details Section Ends -->
          <hr>
          <!-- Bank Details & Total Amount Section  -->
          <div class="row">
            <!-- Terms and conditions -->
            <div class="col-sm-6">
              <h3 class="payment-terms" style="color:#303030">Bank Details</h3>
              FNB Cheque Account: 62589280066
            </div>
            <!-- Totals -->
            <div class="col-sm-6 align-right">
              <table id="table-invoice-total" class="table table-striped table-hover">
                <tbody>
                  <tr>
                    <th class="verticle-th">Total Net Amount</th>
                    <td>ZAR {{ model.net_amount }}</td>
                  </tr>
                  <tr>
                    <th class="verticle-th">Total VAT Amount</th>
                    <td>ZAR {{ model.vat_amount }}</td>
                  </tr>
                  <tr>
                    <th class="verticle-th">Total</th>
                    <td>ZAR {{ model.total_amount }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /col6 -->
          </div>
          <!-- Bank Details & Total Amount Section Ends -->
        </div>
        <!-------------------------------Pictures to show------------------------->
        <b-form-group
          :label="$t('validation.jobcards.attachment_receipt')"
          label-for="attachment_receipt"
          horizontal
          :label-cols="4"
          :feedback="feedback('jobcard.attachment_receipt')"
        >
        </b-form-group>
        <template>
          <b-row>
            <AttachmentImageGallery
              :id="id"
              :quotes-pic-size="true"
              :image-width="'300px'"
              :image-height="'300px'"
              :attachmentpictures="attachmentpictures"
              :modelattachmentpictures="model.jobcard.attachment_receipt"
              @changeFile="changeAttachmentGalleryImage"
            ></AttachmentImageGallery>
          </b-row>
        </template>
        <!-------------------------------Pictures to show------------------------->
        <!-- ViewPort  Ends -->
        <b-row id="hideback" slot="footer">
          <b-col md>
            <b-button to="/quotes" exact variant="danger" size="md">
              {{ $t('buttons.back') }}
            </b-button>
          </b-col>
        </b-row>
        <!-- Footer Section Ends -->
      </b-card>
    </div>
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
                <div id="labour_part_name_edit_error">{{ errors.labour_name }}</div>
              </b-form-group>
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
            <div id="labour_part_name_edit_error">{{ errors.labour_name }}</div>
          </b-form-group>
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
                <div class="error-alert" id="parts_part_name_edit_error" v-if="errors.parts_name"><p>{{ errors.parts_name }}</p></div>
              </b-form-group>
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
            <div id="parts_part_name_edit_error">{{ errors.parts_name }}</div>
          </b-form-group>
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
import JSPDF from 'jspdf'
import AttachmentImageGallery from './Jobcard/AttachmentImageGallery'

export default {
  name: 'QuotesForm',
  components: {
    AttachmentImageGallery
  },
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
      labourTabIndex: 0,
      sectionStatus: null,
      rowsRemember: null,
      attachmentpictures: [],
      jsonParseImgAttach: false,
      client_search: {
        search_client: null,
        client_info_get: [],
        client_searched_data: []
      },
      labour: {
        labour_name: '',
        labour_quantity: 1,
        labour_rate_zar: 0,
        net_labour_price_zar: 0.00,
        labour_vat_rate: 15.00,
        labour_vat_amount_zar: 0.00,
        labour_total_zar: 0.00
      },
      labour_edit: {
        section_select_edit: '',
        labour_name: '',
        labour_quantity: 1,
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
        parts_quantity: 1,
        parts_rate_zar: 0,
        net_parts_price_zar: 0.00,
        parts_vat_rate: 15.00,
        parts_vat_amount_zar: 0.00,
        parts_total_zar: 0.00
      },
      parts_edit: {
        section_select_edit: '',
        parts_name: '',
        parts_quantity: 1,
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
      printstatus: 1,
      model: {
        quotation_number: null,
        quotation_name: null,
        travelling_time: null,
        travelling_km: null,
        vat_amount: 0.00,
        net_amount: 0.00,
        total_amount: 0.00,
        labour_rates: null,
        materials_rates: null,
        vat_rates: null,
        jobcard_id: null,
        project_id: null,
        project_managers_id: null,
        general_vat_rate: 15.00,
        client_name: null,
        client_email: null,
        quotation_description: null,
        rows: [],
        jobcard: {
          attachment_receipt: []
        },
        quotation_date: null,
        company_address: null,
        company_logo: null,
        bank_account: null
      },
      quotes: {
        quotesNetTotal: 0.00,
        quotesVatTotal: 0.00,
        quotesTotal: 0.00
      },
      errors: {
        parts_name: '',
        labour_name: ''
      }
    }
  },
  computed: {
    randomNumber: function () {
      return 'QU-001'
    }
  },
  watch: {
    'model.project_id': function (val, oldval) {
      if (val) {
        this.getProjectManagers(val)
        if (oldval) {
          if (val !== oldval) {
            this.model.project_managers_id = ''
          }
        }
      }
    },
    'model.jobcard_id': function (val) {
      if (val) {
        this.getJobcardsFacility(val)
      } else {
        this.model.quotation_name = ''
      }
    },
    'model.jobcard.attachment_receipt': function (val) {
      console.log(val)
      if (val && val.length > 0) {
        if (!this.isNew && !this.jsonParseImgAttach) {
          this.jsonParseImgAttach = true
          this.model.jobcard.attachment_receipt = JSON.parse(val)
          // console.log(this.model.attachment_receipt);
          var Workordrimg = JSON.parse(val)
          Workordrimg.map((item) => {
            if (item.image_name) {
              this.attachmentpictures.push(item.image_name)
            }
          })
        }
      }
    },
    'jobcards_facility': function (val) {
      if (val) {
        this.model.quotation_name = val.jobcard_num + '-' + val.facility_name
      }
    },
    'last_quote_ref': function (val) {
      if (val) {
        this.model.quotation_number = parseInt(val) + 1
      } else {
        // check value quote ref start from settings
        if (this.settings.quote_ref_start) {
          this.model.quotation_number = this.settings.quote_ref_start + 1
        } else {
          alert('Please Add Quote Reference Start From Settings')
          this.$router.push('/settings')
        }
      }
    },
    'rows': function (val) {
      this.quotes.quotesNetTotal = 0.00
      this.quotes.quotesVatTotal = 0.00
      var saveVal = 'empty'
      val.forEach((item, index) => {
        if (item.labour || item.parts) {
          if (!this.isNew) {
            this.quotes.quotesNetTotal += parseInt(item.net_total).toFixed(2)
            this.quotes.quotesVatTotal += this.model.vat_rates.toFixed(2) * item.net_total.toFixed(2) / 100
          } else {
            this.quotes.quotesNetTotal += parseInt(item.net_total).toFixed(2)
            this.quotes.quotesVatTotal += this.settings.quote_vat.toFixed(2) * item.net_total.toFixed(2) / 100
          }
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
      this.model.net_amount = (this.quotes.quotesNetTotal).toFixed(2)
      this.model.vat_amount = (this.quotes.quotesVatTotal).toFixed(2)
      this.model.total_amount = (this.quotes.quotesTotal = parseInt(this.quotes.quotesNetTotal) + parseInt(this.quotes.quotesVatTotal)).toFixed(2)
      this.model.rows = val
    },
    'model.rows': function (val) {
      // console.log(typeof val)
      if (!this.rowsRemember && !this.isNew) {
        this.rows = JSON.parse(val)
        this.rowsRemember = 1
      }
    },
    'parts.parts_name': function (val) {
      if (val) {
        this.errors.parts_name = ''
      }
      if (val === '') {
        this.errors.parts_name = 'Name cannot be empty'
      }
    },
    'parts_edit.parts_name': function (val) {
      if (val) {
        this.errors.parts_name = ''
      }
      if (val === '') {
        this.errors.parts_name = 'Name cannot be empty'
      }
    },
    'labour.labour_name': function (val) {
      if (val) {
        this.errors.labour_name = ''
      }
      if (val === '') {
        this.errors.labour_name = 'Name cannot be empty'
      }
    },
    'labour_edit.labour_name': function (val) {
      if (val) {
        this.errors.labour_name = ''
      }
      if (val === '') {
        this.errors.labour_name = 'Name cannot be empty'
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
    this.getJobcards()
    this.getProjects()
    this.getSettings()
    this.getQuotesReference()
  },
  methods: {
    printquotes: function () {
      this.printstatus = null
      setTimeout(function () {
        this.printstatus = 1
        window.print()
      }, 1000)
    },
    downloadjspdf: function () {
      // Landscape export, 2×4 inches
      var doc = new JSPDF({
        orientation: 'landscape',
        unit: 'in',
        format: [4, 2]
      })
      var source = window.document.getElementById('quotes-view')
      doc.fromHTML(
        source,
        15,
        15
      )
      // console.log(doc)
      // doc.save('dataurlnewwindow.pdf')
    },
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
    changeAttachmentGalleryImage (images) {
      this.model.attachment_receipt = images
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
      this.model.client_email = this.client_search.client_info_get[index].email
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
      let netLabourprice = parseFloat(this.labour.net_labour_price_zar).toFixed(2)
      let labourvatRate = parseFloat(this.labour.labour_vat_rate).toFixed(2)
      let labourvatAmmount = parseFloat(this.labour.labour_vat_amount_zar).toFixed(2)
      let labourRateZar = parseFloat(this.labour.labour_rate_zar).toFixed(2)
      let labourQuantity = parseFloat(this.labour.labour_quantity).toFixed(2)
      let EditlabourQuantities = parseFloat(this.labour_edit.labour_quantity).toFixed(2)
      let EditLabourRateZar = parseFloat(this.labour_edit.labour_rate_zar).toFixed(2)
      let EditLabourPriceZar = parseFloat(this.labour_edit.net_labour_price_zar).toFixed(2)
      let EditVatRate = parseFloat(this.labour_edit.labour_vat_rate).toFixed(2)
      let EditlabourVatZar = parseFloat(this.labour_edit.labour_vat_amount_zar).toFixed(2)
      this.labour.net_labour_price_zar = labourQuantity * labourRateZar
      this.labour.labour_vat_amount_zar = (labourvatRate * netLabourprice) / 100
      this.labour.labour_total_zar = netLabourprice + labourvatAmmount
      // On Edit LabourRate Change
      this.labour_edit.net_labour_price_zar = EditlabourQuantities * EditLabourRateZar
      this.labour_edit.labour_vat_amount_zar = (EditVatRate * EditLabourPriceZar) / 100
      this.labour_edit.labour_total_zar = EditLabourPriceZar + EditlabourVatZar
    },
    AddLabour: function () {
      if (this.labour.labour_name === '') {
        this.errors.labour_name = 'Name cannot be empty.'
        return false
      } else {
        this.errors.labour_name = ''
      }
      if (this.section_select !== 'null') {
        this.rows.splice(this.section_select + 1, 0, { labour: this.labour.labour_name, parent_section: this.section_select, name: this.labour.labour_name, quantity: this.labour.labour_quantity, net_amount: this.labour.labour_rate_zar, net_total: this.labour.net_labour_price_zar.tofixed(2), labour_vat_rate: this.labour.labour_vat_rate, labour_vat_amount_zar: this.labour.labour_vat_amount_zar, labour_total_zar: this.labour.labour_total_zar })
      } else {
        this.rows.unshift({ labour: this.labour.labour_name, parent_section: this.section_select, name: this.labour.labour_name, quantity: this.labour.labour_quantity, net_amount: this.labour.labour_rate_zar.tofixed(2), net_total: this.labour.net_labour_price_zar.tofixed(2), labour_vat_rate: this.labour.labour_vat_rate, labour_vat_amount_zar: this.labour.labour_vat_amount_zar, labour_total_zar: this.labour.labour_total_zar })
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
      this.parts.net_parts_price_zar = (parseFloat(this.parts.parts_quantity) * parseFloat(this.parts.parts_rate_zar)).toFixed(2)
      this.parts.parts_vat_amount_zar = ((this.parts.parts_vat_rate * this.parts.net_parts_price_zar) / 100).toFixed(2)
      this.parts.parts_total_zar = (this.parts.net_parts_price_zar + this.parts.parts_vat_amount_zar).toFixed(2)
      // On Edit PartsRate Change
      this.parts_edit.net_parts_price_zar = (parseFloat(this.parts_edit.parts_quantity) * parseFloat(this.parts_edit.parts_rate_zar)).toFixed(2)
      this.parts_edit.parts_vat_amount_zar = ((this.parts_edit.parts_vat_rate * this.parts_edit.net_parts_price_zar) / 100).toFixed(2)
      this.parts_edit.parts_total_zar = (this.parts_edit.net_parts_price_zar + this.parts_edit.parts_vat_amount_zar).toFixed(2)
    },
    AddParts: function () {
      this.errors.parts_name = ''
      if (this.parts.parts_name === '') {
        this.errors.parts_name = 'Name cannot be empty.'
        return false
      } else {
        this.errors.parts_name = ''
      }
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

      this.labour.net_labour_price_zar = (parseFloat(this.labour.labour_quantity) * parseFloat(this.labour.labour_rate_zar)).toFixed(2)
      this.labour.labour_vat_amount_zar = ((this.labour.labour_vat_rate * this.labour.net_labour_price_zar) / 100).toFixed(2)
      this.labour.labour_total_zar = (this.labour.net_labour_price_zar + this.labour.labour_vat_amount_zar).toFixed(2)
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
      this.model.vat_rates = this.settings.quote_vat = data.quote_vat
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
      if (ModalRef === 'sectionModalRef') {
        this.$refs.sectionModalRef.show()
      }
      if (ModalRef === 'AddLabourSection') {
        this.$refs.AddLabourSection.show()
        this.errors.labour_name = ''
      }
      if (ModalRef === 'AddPartsSection') {
        this.$refs.AddPartsSection.show()
        this.errors.parts_name = ''
      }
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
        this.emptyLabourText()
      }
      if (ModalRef === 'addPartsSection') {
        this.$refs.AddPartsSection.hide()
        this.emptyPartsText()
      }
      if (ModalRef === 'updatePartsSection') {
        this.$refs.updatePartsSection.hide()
        this.emptyPartsText()
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
      this.labour.labour_quantity = 1
      this.labour.labour_rate_zar = 0
      this.labour.labour_vat_rate = this.settings.quote_vat
      this.labour.labour_vat_amount_zar = 0.00
      this.labour.net_labour_price_zar = 0.00
      this.labour.labour_total_zar = 0.00
      this.errors.labour_name = ''
    },
    emptyPartsText: function () {
      this.parts.parts_name = ''
      this.parts.parts_quantity = 1
      this.parts.parts_rate_zar = 0
      this.parts.parts_vat_rate = this.settings.quote_vat
      this.parts.parts_vat_amount_zar = 0.00
      this.parts.net_parts_price_zar = 0.00
      this.parts.parts_total_zar = 0.00
      this.errors.parts_name = ''
    },
    print: function (div) {
      // var divToPrint = document.getElementById(div)
      // var newWin = window.open()
      // newWin.document.write(divToPrint.innerHTML)
      // newWin.location.reload()
      // newWin.focus()
      // newWin.print()
      // newWin.close()
      var printWindow = window.open('/admin/quotes/3/printpdf ', 'popupWindow', 'width=600,height=600,scrollbars=yes')
      printWindow.print()
    }
  }
}
</script>
