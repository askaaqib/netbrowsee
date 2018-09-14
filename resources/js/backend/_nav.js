export default (app, i18n, newPostsCount, pendingPostsCount) => {
  return [
    {
      name: i18n.t('labels.backend.titles.dashboard'),
      url: '/dashboard',
      icon: 'fe fe-trending-up',
      access: true
    },
    {
      divider: true,
      access: true
    },
    {
      title: true,
      name: i18n.t('labels.backend.sidebar.content'),
      access: app.blogEnabled && app.user.can('view own posts')
    },
    {
      name: i18n.t('labels.backend.jobcards.titles.main'),
      url: '/jobcards',
      icon: 'fe fe-grid',
      access: app.user.can('view')
    },
    {
      name: i18n.t('labels.backend.projects.titles.main'),
      url: '/projects',
      icon: 'fe fe-aperture',
      access: app.user.can('view')
    },
    {
      name: i18n.t('labels.backend.project_managers.titles.main'),
      url: '/project_managers',
      icon: 'fe fe-user',
      access: app.user.can('view')
    },
    {
      name: i18n.t('labels.backend.labour_rates.titles.main'),
      url: '/labour_rates',
      icon: 'fe fe-layers',
      access: app.user.can('view')
    },
    {
      name: i18n.t('labels.backend.materials_rates.titles.main'),
      url: '/materials_rates',
      icon: 'fe fe-layers',
      access: app.user.can('view')
    },
    {
      name: i18n.t('labels.backend.vat.titles.main'),
      url: '/vat',
      icon: 'fe fe-layers',
      access: app.user.can('view')
    },
    {
      divider: true,
      access: true
    },
    {
      title: true,
      name: i18n.t('labels.backend.sidebar.access'),
      access: app.user.can('view users') || app.user.can('view roles')
    },
    {
      name: i18n.t('labels.backend.users.titles.main'),
      url: '/users',
      icon: 'fe fe-users',
      access: app.user.can('view users')
    },
    {
      name: i18n.t('labels.backend.roles.titles.main'),
      url: '/roles',
      icon: 'fe fe-shield',
      access: app.user.can('view roles')
    },
    {
      divider: true,
      access: true
    },
    {
      title: true,
      name: 'Quotation Management',
      access: app.blogEnabled && app.user.can('view')
    },
    {
      name: 'Quotes',
      url: '/quotes',
      icon: 'fe fe-info',
      access: app.user.can('view')
    },
    {
      divider: true,
      access: true
    },
    {
      title: true,
      name: 'Reports Management',
      access: app.blogEnabled && app.user.can('view')
    },
    {
      name: 'Reports',
      url: '/reports',
      icon: 'fe fe-bar-chart-2',
      access: app.user.can('view')
    }
  ]
}
