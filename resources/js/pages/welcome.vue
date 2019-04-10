<template>
  <div class="container">
    <div class="top-right links" style="z-index:99">
      <template v-if="authenticated">
        <a href="/dashboard">Dashboard</a>
      </template>
    </div>


    <div class="row">
      <div class="col-10 text-center">

        <carousel v-if="images.length" :autoplay="true" :per-page="1" :center-mode="true">
          <slide class="p-1" v-for="(image, index) in images" :key="index">

          <div class="text-center">
            <img width="600" height="500" :src="image" >
            <br>
          </div>
             <!--  -->
          </slide>
        </carousel>


      </div>

      <div class="col-2 dropdown">
        <button type="button" class="btn btn-clear dropdown-toggle" data-toggle="dropdown">
          <fa icon="bars" fixed-width/>
        </button>
        <div class="dropdown-menu">
          <router-link :to="'history'" class="pl-3">History</router-link>
          <div class="dropdown-divider"></div>
          <router-link :to="'mission'" class="pl-3">Mission</router-link>
          <div class="dropdown-divider"></div>
          <router-link :to="'vision'" class="pl-3">Vision</router-link>
          <div class="dropdown-divider"></div>
          <router-link :to="'core-values'" class="pl-3">Core Values</router-link>
          <div class="dropdown-divider"></div>
          <router-link :to="'contact'" class="pl-3">Contact Us</router-link>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import { Carousel, Slide } from 'vue-carousel';
import { mapGetters } from 'vuex'
import LoginComponent from '~/components/auth/login.vue'
import { playSound } from '~/helpers'
import { SOUND_TYPES } from '~/constants'

export default {
  metaInfo () {
    return { title: this.$t('home') }
  },

  components: {
    Carousel,
    Slide,
    'app-login': LoginComponent
  },

  data: () => ({
    title: window.config.appName,
    images: window.images,
    show_login: false
  }),

  computed: mapGetters({
    authenticated: 'auth/check',
    user: 'auth/user'
  }),

  mounted () {
    setTimeout(() => {
      const sound = _.get(localStorage, 'play_sound')
      if (sound) {
        playSound(sound)
        _.set(localStorage, 'play_sound', '')
      }
      playSound(SOUND_TYPES.HOMEPAGE)
    }, 1000)
  },
  
  methods: {
    showLogin (show = true) {
      this.show_login = show
    }
  },
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
