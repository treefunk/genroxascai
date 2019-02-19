<template>
  <transition name="slideDown" v-if="isReady">
  <div class="mb-3">
      <div v-if="isModules()" class="card-body bg-light p-2">
      Modules
    </div>
    <div v-if="isLessons() && module" class="card-body bg-light p-2">
      <router-link :to="getModulesRoute()">Modules </router-link> /
        {{ module.name }}
    </div>
    <div v-if="isLessonsOptions() && module && lesson" class="card-body bg-light p-2">
      <router-link :to="getModulesRoute()">Modules </router-link> /
      <router-link :to="getLessonsRoute()">{{ module.name }} </router-link> /
      Lessons /
      {{ lesson.name }}
    </div>

    <div v-if="isReviewMaterials() && module && lesson" class="card-body bg-light p-2">
      <router-link :to="getModulesRoute()">Modules </router-link> /
      <router-link :to="getLessonsRoute()">{{ module.name }} </router-link> /
      Lessons /
      <router-link :to="getLessonOptionsRoute()">{{ lesson.name }} </router-link> /
        Review Materials
    </div>
  </div>
  </transition>
</template>


<script>
import * as _ from 'lodash'
import { mapGetters } from 'vuex'
import { ROUTE_NAMES } from '~/constants'
import { getModulesRoute, getLessonsRoute, getLessonOptionsRoute } from '~/helpers'
export default {
  data () {
    return {
      isReady: false
    }
  },
  computed: mapGetters({
    module: 'module/module',
    lesson: 'lesson/lesson',
    review_materials: 'review_material/all',
  }),
  methods: {
    isReadyToAnimate() {
      return this.lesson || this.module
    },
    isLessons () {
      return this.$route.name === ROUTE_NAMES.LESSONS
    },
    isModules () {
      return this.$route.name === ROUTE_NAMES.MODULES
    },
    isLessonsOptions () {
      return this.$route.name === ROUTE_NAMES.LESSONS_OPTIONS
    },
    isReviewMaterials () {
      return this.$route.name === ROUTE_NAMES.REVIEW_MATERIALS
    },
    getModulesRoute () {
      return getModulesRoute()
    },
    getLessonsRoute() {
      return getLessonsRoute(this.module)
    },
    getLessonOptionsRoute() {
      return getLessonOptionsRoute(this.lesson)
    }
  },
  mounted () {
    setTimeout(() => {
      this.isReady = true
    }, 300)
  }
}
</script>
