<template>
  <transition name="slideDown" v-if="isReady">
  <div class="mb-3">
      <div v-if="isModules()" class="card-body bg-breadcrumbs p-2">
      Yunit
    </div>
    <div v-if="isLessons() && module" class="card-body bg-breadcrumbs p-2">
      <router-link :to="getModulesRoute()">Yunit</router-link> /
        {{ module.name }} / Aralin
    </div>
    <div v-if="isLessonsOptions() && module && lesson" class="card-body bg-breadcrumbs p-2">
      <router-link :to="getModulesRoute()">Yunit</router-link> /
      <router-link :to="getLessonsRoute()">{{ module.name }}</router-link> /
      Aralin /
      {{ lesson.name }}
    </div>

    <div v-if="isDrills() && module && lesson" class="card-body bg-breadcrumbs p-2">
      <router-link :to="getModulesRoute()">Yunit</router-link> /
      <router-link :to="getLessonsRoute()">{{ module.name }}</router-link> /
      Aralin /
      <router-link :to="getLessonOptionsRoute()">{{ lesson.name }}</router-link> /
        Drills
    </div>

    <div v-if="isDrill() && module && lesson && drill" class="card-body bg-breadcrumbs p-2">
      <router-link :to="getModulesRoute()">Modules </router-link> /
      <router-link :to="getLessonsRoute()">{{ module.name }} </router-link> /
      Aralin /
      <router-link :to="getLessonOptionsRoute()">{{ lesson.name }}</router-link> /
      <router-link :to="getDrillsRoute()">Drills</router-link> /
      {{ drill.name }}
    </div>

    <div v-if="isReviewMaterials() && module && lesson" class="card-body bg-breadcrumbs p-2">
      <router-link :to="getModulesRoute()">Yunit</router-link> /
      <router-link :to="getLessonsRoute()">{{ module.name }}</router-link> /
      Aralin /
      <router-link :to="getLessonOptionsRoute()">{{ lesson.name }}</router-link> /
        Review Materials
    </div>

    <div v-if="isReviewMaterial() && module && lesson && review_material" class="card-body bg-breadcrumbs p-2">
      <router-link :to="getModulesRoute()">Modules </router-link> /
      <router-link :to="getLessonsRoute()">{{ module.name }} </router-link> /
      Aralin /
      <router-link :to="getLessonOptionsRoute()">{{ lesson.name }}</router-link> /
      <router-link :to="getReviewMaterialsRoute()">Review Materials</router-link> /
      {{ review_material.name }}
    </div>

    <div v-if="(isPreTest() || isPostTest()) && module && lesson && test" class="card-body bg-breadcrumbs p-2">
      <router-link :to="getModulesRoute()">Modules </router-link> /
      <router-link :to="getLessonsRoute()">{{ module.name }} </router-link> /
      Aralin /
      <router-link :to="getLessonOptionsRoute()">{{ lesson.name }}</router-link> /
      {{ isPreTest() ? 'Pre Test' : 'Post Test' }}
    </div>

  </div>
  </transition>
</template>

<script>
import * as _ from 'lodash'
import { mapGetters } from 'vuex'
import { ROUTE_NAMES } from '~/constants'
import { getModulesRoute, getLessonsRoute, getLessonOptionsRoute, getReviewMaterialsRoute, getDrillsRoute } from '~/helpers'
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
    review_material: 'review_material/review_material',
    drills: 'drill/all',
    drill: 'drill/drill',
    test: 'test/test',
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
    isReviewMaterial () {
      return this.$route.name === ROUTE_NAMES.REVIEW_MATERIAL
    },
    isDrills () {
      return this.$route.name === ROUTE_NAMES.DRILLS
    },
    isDrill () {
      return this.$route.name === ROUTE_NAMES.DRILL
    },
    isPreTest () {
      return this.$route.name === ROUTE_NAMES.PRETEST
    },
    isPostTest () {
      return this.$route.name === ROUTE_NAMES.POSTTEST
    },
    getModulesRoute () {
      return getModulesRoute()
    },
    getLessonsRoute() {
      return getLessonsRoute(this.module)
    },
    getLessonOptionsRoute() {
      return getLessonOptionsRoute(this.lesson)
    },
    getReviewMaterialsRoute() {
      return getReviewMaterialsRoute(this.lesson)
    },
    getDrillsRoute() {
      return getDrillsRoute(this.lesson)
    }
  },
  mounted () {
    setTimeout(() => {
      this.isReady = true
    }, 300)
  }
}
</script>
