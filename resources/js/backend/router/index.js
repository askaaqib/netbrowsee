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
import FormSettingForm from '../views/FormSettingForm'
import FormSettingList from '../views/FormSettingList'
import FormSubmissionShow from '../views/FormSubmissionShow'
import FormSubmissionList from '../views/FormSubmissionList'
import UserForm from '../views/UserForm'
import UserList from '../views/UserList'
import RoleForm from '../views/RoleForm'
import RoleList from '../views/RoleList'
import quotesForm from '../views/quotesForm'
import quotesList from '../views/quotesList'

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
          },
          {
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
          },
          {
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
                component: quotesList,
                meta: {
                  label: i18n.t('labels.backend.quotes.titles.index')
                }
              },
              {
                path: 'create',
                name: 'quotes_create',
                component: quotesForm,
                meta: {
                  label: i18n.t('labels.backend.quotes.titles.create')
                }
              },
              {
                path: ':id/edit',
                name: 'quotes_edit',
                component: quotesForm,
                props: true,
                meta: {
                  label: i18n.t('labels.backend.quotes.titles.edit')
                }
              }
            ]
          }
        ]
      }
    ]
  })
}
