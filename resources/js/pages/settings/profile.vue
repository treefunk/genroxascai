<template>
  <card :title="$t('your_info')">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('info_updated')"/>

      <div v-if="user.civil_status" class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Civil Status</label>
        <div class="col-md-7">
          <p class="mt-2 mb-1">{{ user.civil_status | capitalize }}</p>
        </div>
      </div>

      <div v-if="user.section_id" class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Section</label>
        <div class="col-md-7">
          <p class="mt-2 mb-1">{{ user.section_name }}</p>
        </div>
      </div>





      <!-- Username -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Username</label>
        <div class="col-md-7">
          <input v-model="form.username" :class="{ 'is-invalid': form.errors.has('username') }" class="form-control" type="text" name="username">
          <has-error :form="form" field="username" />
        </div>
      </div>

      <!-- Submit Button -->
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
          <v-button :loading="form.busy" type="success">{{ $t('update') }}</v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      username: ''
    })
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  created () {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },

  methods: {
    async update () {
      const { data } = await this.form.patch('/api/settings/profile')

      this.$store.dispatch('auth/updateUser', { user: data })
    }
  }
}
</script>
