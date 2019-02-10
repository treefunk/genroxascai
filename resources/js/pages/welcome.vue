<template>
  <div>
    <div class="top-right links">
        <template v-if="authenticated && user.role == 'admin'">
          <router-link :to="{ name: 'admin_dashboard' }">
            {{ $t('Admin Dashboard') }}
          </router-link>
        </template>

        <template v-if="authenticated && user.role == 'teacher'">
          <router-link :to="{ name: 'teacher_dashboard' }">
            {{ $t('Teacher Dashboard') }}
          </router-link>
        </template>

        <template v-if="authenticated && user.role == 'student'">
          <router-link :to="{ name: 'student_dashboard' }">
            {{ $t('Student Dashboard') }}
          </router-link>
        </template>

      <template v-if="!authenticated">
        <router-link :to="{ name: 'login' }">
          {{ $t('login') }}
        </router-link>
        <router-link :to="{ name: 'register' }">
          {{ $t('register') }}
        </router-link>
      </template>
    </div>

    <div class="text-center">
      <div class="title mb-4">
        {{ title }}
      </div>

      <div class="links">
        <a href="https://laravel.com/docs">Documentation</a>
        <a href="https://laracasts.com">Laracasts</a>
        <a href="https://laravel-news.com">News</a>
        <a href="https://forge.laravel.com">Forge</a>
        <a href="https://github.com/laravel/laravel">GitHub</a>
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
