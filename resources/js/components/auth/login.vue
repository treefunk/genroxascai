<template>

      <div class="card">
        <div class="card-header">
          {{ $t('login') }}
          <button type="button" class="close" @click="$emit('close')">&times;</button>
        </div>
        <div class="card-body">
          <form @submit.prevent="login" @keydown="form.onKeydown($event)">
            <!-- Username -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">Username</label>
              <div class="col-md-7">
                <input v-model="form.username" :class="{ 'is-invalid': form.errors.has('username') }" class="form-control" type="text" name="username">
                <has-error :form="form" field="username"/>
              </div>
            </div>

            <!-- Password -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>
              <div class="col-md-7">
                <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
                <has-error :form="form" field="password"/>
              </div>
            </div>

            <!-- Remember Me -->
            <div class="form-group row">
              <div class="col-md-3"/>
              <div class="col-md-7 d-flex">
                <checkbox v-model="remember" name="remember">
                  {{ $t('remember_me') }}
                </checkbox>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-7 offset-md-3 d-flex">
                <!-- Submit Button -->
                <v-button :loading="form.busy">
                  {{ $t('login') }}
                </v-button>
              </div>
            </div>
          </form>
        </div>
      </div>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'
import { SOUND_TYPES } from '~/constants'

export default {
  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('login') }
  },

  data: () => ({
    form: new Form({
      username: '',
      password: ''
    }),
    remember: false
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async login () {
      // Submit the form.
      const { data } = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      const isTeacher = _.get(this.user, 'is_teacher')
      if (isTeacher) {
        localStorage.play_sound = SOUND_TYPES.LOGIN_TEACHER
      } else if (!_.get(this.user, 'is_admin')) {
        localStorage.play_sound = SOUND_TYPES.LOGIN_STUDENT
      }

      if (!_.get(this.user, 'password_updated')) {
        location.href = "settings/password"
        return;
      }

      location.href = "dashboard"
    }
  },
  mounted () {
  }
}
</script>
