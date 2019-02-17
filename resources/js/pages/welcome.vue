<template>
  <div>
    <div class="top-right links">
      <template v-if="authenticated">
        <a href="/dashboard">Dashboard</a>
      </template>
      <template v-if="!authenticated">
        <router-link :to="{ name: 'login' }">
          {{ $t('login') }}
        </router-link>
      </template>
    </div>

    <div class="text-center">
      <div class="title mb-4">
        {{ title }}
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  layout: 'basic',
  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check',
    user: 'auth/user'
  })
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}
</style>
