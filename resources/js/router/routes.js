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

// const Dashboard = () => import('~/pages/Dashboard').then(m => m.default || m)
const Modules = () => import('~/pages/modules/index').then(m => m.default || m)
const Lessons = () => import('~/pages/lessons/index').then(m => m.default || m)
const LessonsOptions = () => import('~/pages/lessons/options').then(m => m.default || m)

const ReviewMaterials = () => import('~/pages/review_materials/index').then(m => m.default || m)
const ReviewMaterial = () => import('~/pages/review_materials/show').then(m => m.default || m)

const PreTest = () => import('~/pages/pretests/index').then(m => m.default || m)

const PostTest = () => import('~/pages/posttests/index').then(m => m.default || m)
const PeriodicalTest = () => import('~/pages/periodicaltests/index').then(m => m.default || m)

const Drills = () => import('~/pages/drills/index').then(m => m.default || m)
const Drill = () => import('~/pages/drills/show').then(m => m.default || m)

export default [
  { path: '/', name: ROUTE_NAMES.WELCOME, component: Welcome },

  { path: '/login', name: ROUTE_NAMES.LOGIN, component: Login },
  { path: '/password/reset', name: ROUTE_NAMES.PASSWORD_REQUEST, component: PasswordEmail },
  { path: '/password/reset/:token', name: ROUTE_NAMES.PASSWORD_RESET, component: PasswordReset },

  { path: '/home', name: ROUTE_NAMES.HOME, component: Home },
  { path: '/dashboard', name: ROUTE_NAMES.DASHBOARD, component: Modules },
  { path: '/modules', name: ROUTE_NAMES.MODULES, component: Modules },
  { path: '/modules/:module_id/lessons', name: ROUTE_NAMES.LESSONS, component: Lessons },
  { path: '/modules/:module_id/lessons/:lesson_id', name: ROUTE_NAMES.LESSONS_OPTIONS, component: LessonsOptions },

  { path: '/modules/:module_id/lessons/:lesson_id/review_materials', name: ROUTE_NAMES.REVIEW_MATERIALS, component: ReviewMaterials },
  { path: '/modules/:module_id/lessons/:lesson_id/review_materials/:review_material_id', name: ROUTE_NAMES.REVIEW_MATERIAL, component: ReviewMaterial },

  { path: '/modules/:module_id/lessons/:lesson_id/pretest', name: ROUTE_NAMES.PRETEST, component: PreTest },
  { path: '/modules/:module_id/lessons/:lesson_id/posttest', name: ROUTE_NAMES.POSTTEST, component: PostTest },
  { path: '/modules/:module_id/periodicaltest', name: ROUTE_NAMES.PERIODICALTEST, component: PeriodicalTest },

  { path: '/modules/:module_id/lessons/:lesson_id/drills', name: ROUTE_NAMES.DRILLS, component: Drills },
  { path: '/modules/:module_id/lessons/:lesson_id/drills/:drill_id', name: ROUTE_NAMES.DRILL, component: Drill },

  { path: '/settings',
    component: Settings,
    children: [
      { path: '', redirect: { name: ROUTE_NAMES.SETTINGS_PROFILE } },
      { path: 'profile', name: ROUTE_NAMES.SETTINGS_PROFILE, component: SettingsProfile },
      { path: 'password', name: ROUTE_NAMES.SETTINGS_PASSWORD, component: SettingsPassword }
    ] },

  { path: '*', component: NotFound }
]
