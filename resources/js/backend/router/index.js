import Vue from 'vue'
import Router from 'vue-router'
// Containers
import Full from '../containers/Full'
// Views
import Search from '../views/Search'
import Dashboard from '../views/Dashboard'
import PostForm from '../views/PostForm'
import JobcardForm from '../views/JobcardForm'
import PostList from '../views/PostList'
import JobcardList from '../views/JobcardList'
import ProjectList from '../views/ProjectList'
import ProjectForm from '../views/ProjectForm'
import ProjectManagerList from '../views/ProjectManagerList'
import ProjectManagerForm from '../views/ProjectManagerForm'
import LabourRateList from '../views/LabourRateList'
import LabourRateForm from '../views/LabourRateForm'
import MaterialRateList from '../views/MaterialRateList'
import MaterialRateForm from '../views/MaterialRateForm'
import VatList from '../views/VatList'
import VatForm from '../views/VatForm'
import ReportsList from '../views/ReportsList'
import ReportsForm from '../views/ReportsForm'
// import SettingsList from '../views/SettingsList'
import SettingsForm from '../views/SettingsForm'
import InvoicesList from '../views/InvoicesList'
import InvoicesForm from '../views/InvoicesForm'
import InvoiceShow from '../views/InvoiceShow'
import FormSettingForm from '../views/FormSettingForm'
import FormSettingList from '../views/FormSettingList'
import FormSubmissionShow from '../views/FormSubmissionShow'
import FormSubmissionList from '../views/FormSubmissionList'
import UserForm from '../views/UserForm'
import UserList from '../views/UserList'
import RoleForm from '../views/RoleForm'
import RoleList from '../views/RoleList'
import QuotesForm from '../views/QuotesForm'
import QuotesList from '../views/QuotesList'
import QuotesShow from '../views/QuotesShow'
import QuotesPdf from '../views/QuotesPdf'
import DistrictForm from '../views/DistrictForm'
import DistrictList from '../views/DistrictList'
import SubDistrictForm from '../views/SubDistrictForm'
import SubDistrictList from '../views/SubDistrictList'

Vue.use(Router)

export function createRouter (base, i18n) {
  return new Router({
    mode: 'history',
    base: base,
    linkActiveClass: 'open active',
    scrollBehavior: () => ({ y: 0 }),
    routes: [
      {
        path: '/',
        redirect: '/dashboard',
        name: 'home',
        component: Full,
        meta: {
          label: i18n.t('labels.frontend.titles.administration')
        },
        children: [
          {
            path: 'search',
            name: 'search',
            component: Search,
            meta: {
              label: i18n.t('labels.search')
            }
          },
          {
            path: 'dashboard',
            name: 'dashboard',
            component: Dashboard,
            meta: {
              label: i18n.t('labels.backend.titles.dashboard')
            }
          },
          {
            path: 'posts',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.posts.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'posts',
                component: PostList,
                meta: {
                  label: i18n.t('labels.backend.posts.titles.index')
                }
              },
              {
                path: 'create',
                name: 'posts_create',
                component: PostForm,
                meta: {
                  label: i18n.t('labels.backend.posts.titles.create')
                }
              },
              {
                path: ':id/edit',
                name: 'posts_edit',
                component: PostForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.posts.titles.edit')
                }
              }
            ]
          },
          {
            path: 'jobcards',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.jobcards.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'jobcards',
                component: JobcardList,
                meta: {
                  label: i18n.t('labels.backend.jobcards.titles.index')
                }
              },
              {
                path: 'create',
                name: 'jobcards_create',
                component: JobcardForm,
                meta: {
                  label: i18n.t('labels.backend.jobcards.titles.create')
                }
              },
              {
                path: ':id/edit',
                name: 'jobcards_edit',
                component: JobcardForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.jobcards.titles.edit')
                }
              }
            ]
          },
          {
            path: 'projects',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.projects.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'projects',
                component: ProjectList,
                meta: {
                  label: i18n.t('labels.backend.projects.titles.index')
                }
              },
              {
                path: 'create',
                name: 'projects_create',
                component: ProjectForm,
                meta: {
                  label: i18n.t('labels.backend.projects.titles.create')
                }
              },
              {
                path: ':id/edit',
                name: 'projects_edit',
                component: ProjectForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.projects.titles.edit')
                }
              }
            ]
          },
          {
            path: 'project_managers',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.project_managers.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'project_managers',
                component: ProjectManagerList,
                meta: {
                  label: i18n.t('labels.backend.project_managers.titles.index')
                }
              },
              {
                path: 'create',
                name: 'project_managers_create',
                component: ProjectManagerForm,
                meta: {
                  label: i18n.t('labels.backend.project_managers.titles.create')
                }
              },
              {
                path: ':id/edit',
                name: 'project_managers_edit',
                component: ProjectManagerForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.project_managers.titles.edit')
                }
              }
            ]
          },
          {
            path: 'labour_rates',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.labour_rates.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'labour_rates',
                component: LabourRateList,
                meta: {
                  label: i18n.t('labels.backend.labour_rates.titles.index')
                }
              },
              {
                path: 'create',
                name: 'labour_rates_create',
                component: LabourRateForm,
                meta: {
                  label: i18n.t('labels.backend.labour_rates.titles.create')
                }
              },
              {
                path: ':id/edit',
                name: 'labour_rates_edit',
                component: LabourRateForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.labour_rates.titles.edit')
                }
              }
            ]
          },
          {
            path: 'materials_rates',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.materials_rates.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'materials_rates',
                component: MaterialRateList,
                meta: {
                  label: i18n.t('labels.backend.materials_rates.titles.index')
                }
              },
              {
                path: 'create',
                name: 'materials_rates_create',
                component: MaterialRateForm,
                meta: {
                  label: i18n.t('labels.backend.materials_rates.titles.create')
                }
              },
              {
                path: ':id/edit',
                name: 'materials_rates_edit',
                component: MaterialRateForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.materials_rates.titles.edit')
                }
              }
            ]
          },
          {
            path: 'vat',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.vat.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'vat',
                component: VatList,
                meta: {
                  label: i18n.t('labels.backend.vat.titles.index')
                }
              },
              {
                path: 'create',
                name: 'vat_create',
                component: VatForm,
                meta: {
                  label: i18n.t('labels.backend.vat.titles.create')
                }
              },
              {
                path: ':id/edit',
                name: 'vat_edit',
                component: VatForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.vat.titles.edit')
                }
              }
            ]
          },
          {
            path: 'form-submissions',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.form_submissions.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'form_submissions',
                component: FormSubmissionList,
                meta: {
                  label: i18n.t('labels.backend.form_submissions.titles.index')
                }
              },
              {
                path: ':id/show',
                name: 'form_submissions_show',
                component: FormSubmissionShow,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.form_submissions.titles.show')
                }
              }
            ]
          },
          {
            path: 'form-settings',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.form_settings.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'form_settings',
                component: FormSettingList,
                meta: {
                  label: i18n.t('labels.backend.form_settings.titles.index')
                }
              },
              {
                path: 'create',
                name: 'form_settings_create',
                component: FormSettingForm,
                meta: {
                  label: i18n.t('labels.backend.form_settings.titles.create')
                }
              },
              {
                path: ':id/edit',
                name: 'form_settings_edit',
                component: FormSettingForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.form_settings.titles.edit')
                }
              }
            ]
          }, {
            path: 'users',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.users.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'users',
                component: UserList,
                meta: {
                  label: i18n.t('labels.backend.users.titles.index')
                }
              },
              {
                path: 'create',
                name: 'users_create',
                component: UserForm,
                meta: {
                  label: i18n.t('labels.backend.users.titles.create')
                }
              },
              {
                path: ':id/edit',
                name: 'users_edit',
                component: UserForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.users.titles.edit')
                }
              }
            ]
          }, {
            path: 'roles',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.roles.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'roles',
                component: RoleList,
                meta: {
                  label: i18n.t('labels.backend.roles.titles.index')
                }
              },
              {
                path: 'create',
                name: 'roles_create',
                component: RoleForm,
                meta: {
                  label: i18n.t('labels.backend.roles.titles.create')
                }
              },
              {
                path: ':id/edit',
                name: 'roles_edit',
                component: RoleForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.roles.titles.edit')
                }
              }
            ]
          },
          {
            path: 'districts',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.district.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'districts',
                component: DistrictList,
                meta: {
                  label: i18n.t('labels.backend.district.titles.index')
                }
              },
              {
                path: 'create',
                name: 'districts_create',
                component: DistrictForm,
                meta: {
                  label: i18n.t('labels.backend.district.titles.create')
                }
              },
              {
                path: ':id/edit',
                name: 'districts_edit',
                component: DistrictForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.district.titles.edit')
                }
              }
            ]
          },
          {
            path: 'subdistricts',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.subdistrict.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'subdistricts',
                component: SubDistrictList,
                meta: {
                  label: i18n.t('labels.backend.subdistrict.titles.index')
                }
              },
              {
                path: 'create',
                name: 'subdistricts_create',
                component: SubDistrictForm,
                meta: {
                  label: i18n.t('labels.backend.subdistrict.titles.create')
                }
              },
              {
                path: ':id/edit',
                name: 'subdistricts_edit',
                component: SubDistrictForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.district.titles.edit')
                }
              }
            ]
          },
          {
            path: 'quotes',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.quotes.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'quotes',
                component: QuotesList,
                meta: {
                  label: i18n.t('labels.backend.quotes.titles.index')
                }
              },
              {
                path: 'create',
                name: 'quotes_create',
                component: QuotesForm,
                meta: {
                  label: i18n.t('labels.backend.quotes.titles.create')
                }
              },
              {
                path: ':id/view',
                name: 'quotes_show',
                component: QuotesShow,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.quotes.titles.show')
                }
              },
              {
                path: ':id/printpdf',
                name: 'quotes_printpdf',
                component: QuotesPdf,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.quotes.titles.show')
                }
              },
              {
                path: ':id/edit',
                name: 'quotes_edit',
                component: QuotesForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.quotes.titles.edit')
                }
              }
            ]
          },
          {
            path: 'reports',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.reports.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'reports',
                component: ReportsList,
                meta: {
                  label: i18n.t('labels.backend.reports.titles.index')
                }
              },
              {
                path: 'create',
                name: 'reports_create',
                component: ReportsForm,
                meta: {
                  label: i18n.t('labels.backend.reports.titles.create')
                }
              },
              {
                path: ':id/edit',
                name: 'reports_edit',
                component: ReportsForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.reports.titles.edit')
                }
              }
            ]
          },
          {
            path: 'settings',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.settings.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'settings',
                component: SettingsForm,
                meta: {
                  label: i18n.t('labels.backend.settings.titles.index')
                }
              },
              {
                path: 'create',
                name: 'settings_create',
                component: SettingsForm,
                meta: {
                  label: i18n.t('labels.backend.settings.titles.create')
                }
              },
              {
                path: ':id/edit',
                name: 'settings_edit',
                component: SettingsForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.settings.titles.edit')
                }
              }
            ]
          },
          {
            path: 'invoices',
            component: {
              render (c) {
                return c('router-view')
              }
            },
            meta: {
              label: i18n.t('labels.backend.invoices.titles.main')
            },
            children: [
              {
                path: '/',
                name: 'invoices',
                component: InvoicesList,
                meta: {
                  label: i18n.t('labels.backend.invoices.titles.index')
                }
              },
              {
                path: 'create',
                name: 'invoices_create',
                component: InvoicesForm,
                meta: {
                  label: i18n.t('labels.backend.invoices.titles.create')
                }
              },
              {
                path: ':id/view',
                name: 'invoices_show',
                component: InvoiceShow,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.invoices.titles.show')
                }
              },
              {
                path: ':id/edit',
                name: 'invoices_edit',
                component: InvoicesForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.invoices.titles.edit')
                }
              }
            ]
          }
        ]
      }
    ]
  })
}
