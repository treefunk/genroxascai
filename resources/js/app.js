import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'

import '~/plugins'
import '~/components'
import '~/constants'
Vue.config.productionTip = false
import VueCountdownTimer from 'vuejs-countdown-timer'
Vue.use(VueCountdownTimer)


Vue.filter('capitalize', function (value) {
  if (!value) return ''
  value = value.toString()
  return value.charAt(0).toUpperCase() + value.slice(1)
})


/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App,
})

