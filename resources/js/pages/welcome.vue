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
      <div class="mb-4">
        <img style="max-width: 300px;" src="/images/logo.png" class="mb-4">
        <h1>General Roxas Elementary School</h1>
      </div>
      <div>
        <h3>Computer Aided Instruction for ESP3</h3>
      </div>
    </div>

    <carousel v-if="images.length" :autoplay="true" :per-page="1" :center-mode="true">
      <slide class="p-1" v-for="(image, index) in images" :key="image.id">

      <div class="text-center">
        <img width="600" height="500" :src="'/storage/images/' + image.file_name" :alt="image.caption">
        <br>
        <h4>{{ image.caption }}</h4>
      </div>
         <!--  -->
      </slide>
    </carousel>

  </div>
</template>

<script>
import { Carousel, Slide } from 'vue-carousel';
import { mapGetters } from 'vuex'

export default {
  layout: 'basic',
  metaInfo () {
    return { title: this.$t('home') }
  },

  components: {
    Carousel,
    Slide
  },

  data: () => ({
    title: window.config.appName,
    images: window.images
  }),

  computed: mapGetters({
    authenticated: 'auth/check',
    user: 'auth/user'
  }),

  mounted () {
  }
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
