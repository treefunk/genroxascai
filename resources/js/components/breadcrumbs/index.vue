<template>
  <transition name="slideDown" v-if="isReady">
    <div v-if="isModules()" class="card-body bg-light p-2">
      Modules
    </div>
    <div v-if="isLessons() && module" class="card-body bg-light p-2">
      <router-link :to="getModulesRoute()">Modules </router-link>
       / {{ module.name }}
    </div>
    <div v-if="isLessonsOptions() && module && lesson" class="card-body bg-light p-2">
      <router-link :to="getModulesRoute()">Modules </router-link>
         / {{ module.name }} / {{ lesson.name }}
    </div>
  </transition>
</template>


<script>
import * as _ from 'lodash'
import { mapGetters } from 'vuex'
import { ROUTE_NAMES } from '~/constants'
import { getModulesRoute } from '~/helpers'
export default {
  data () {
    return {
      isReady: false
    }
  },
  computed: mapGetters({
    module: 'module/module',
    lesson: 'lesson/lesson',
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
    getModulesRoute () {
      return getModulesRoute()
    }
  },
  mounted () {
    setTimeout(() => {
      this.isReady = true
    }, 300)
  }
}
</script>
