import { ROUTE_NAMES } from '~/constants'

const Welcome = () => import('~/pages/welcome').then(m => m.default || m)
const Login = () => import('~/pages/auth/login').then(m => m.default || m)
const PasswordEmail = () => import('~/pages/auth/password/email').then(m => m.default || m)
const PasswordReset = () => import('~/pages/auth/password/reset').then(m => m.default || m)
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m)

const Home = () => import('~/pages/home').then(m => m.default || m)
const Settings = () => import('~/pages/settings/index').then(m => m.default || m)
const SettingsProfile = () => import('~/pages/settings/profile').then(m => m.default || m)
const SettingsPassword = () => import('~/pages/settings/password').then(m => m.default || m)

const Dashboard = () => import('~/pages/Dashboard').then(m => m.default || m)
const Modules = () => import('~/pages/modules/index').then(m => m.default || m)
const Lessons = () => import('~/pages/lessons/index').then(m => m.default || m)

export default [
  { path: '/', name: ROUTE_NAMES.WELCOME, component: Welcome },

  { path: '/login', name: ROUTE_NAMES.LOGIN, component: Login },
  { path: '/password/reset', name: ROUTE_NAMES.PASSWORD_REQUEST, component: PasswordEmail },
  { path: '/password/reset/:token', name: ROUTE_NAMES.PASSWORD_RESET, component: PasswordReset },

  { path: '/home', name: ROUTE_NAMES.HOME, component: Home },
  { path: '/dashboard', name: ROUTE_NAMES.DASHBOARD, component: Dashboard },
  { path: '/modules', name: ROUTE_NAMES.MODULES, component: Modules },
  { path: '/lessons', name: ROUTE_NAMES.LESSONS, component: Lessons },
  { path: '/settings',
    component: Settings,
    children: [
      { path: '', redirect: { name: ROUTE_NAMES.SETTINGS_PROFILE } },
      { path: 'profile', name: ROUTE_NAMES.SETTINGS_PROFILE, component: SettingsProfile },
      { path: 'password', name: ROUTE_NAMES.SETTINGS_PASSWORD, component: SettingsPassword }
    ] },

  { path: '*', component: NotFound }
]
