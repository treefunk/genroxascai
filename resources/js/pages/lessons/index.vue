<template>
  <div>
    <app-breadcrumbs></app-breadcrumbs>
    <transition name="bounce">
      <h2 v-if="lessons">Mga Aralin</h2>
    </transition>

    <div  class="row colored-cards">
      <div v-for="lesson in lessons" :key="lesson.id" class="col-xl-3 col-sm-6 mb-4">
        <transition name="slideRight">
          <div class="card h-100" :class="{'item-locked': isLocked(lesson)}">
            <div class="card-body">
              <h5 class="card-title">{{ lesson.name }}</h5>
              <p class="card-text">{{ lesson.description }}</p>
            </div>
            <div class="card-footer">
              <router-link :to="getLessonOptionsRoute(lesson)" class="btn btn-primary">View
              </router-link>
            </div>
          </div>
         </transition>
      </div>


      <transition name="slideRight">
        <div v-if="isPeriodicalTestOpen()" class="col-xl-3 col-sm-6 mb-4">
          <div class="card h-100" style="">
            <div class="card-body">
                <h5 class="card-title">Periodical Test</h5>
                <p class="card-text">A test given to students after completion of an instructional program or segment to measure their achievement and the effectiveness of the program.</p>
            </div>
            <div class="card-footer">
              <router-link :to="getPeriodicalTestRoute()" class="btn btn-primary">View
              </router-link>
            </div>
          </div>
        </div>
      </transition>
    </div>

  


    <transition name="slideRight">
      <p v-if="isDataEmpty()">
        Wala pang bukas na aralin
      </p>
    </transition>
  </div>
</template>
<script>
  import * as _ from 'lodash'
  import { mapGetters } from 'vuex'
  import { getLessonOptionsRoute, getPeriodicalTestRoute, isLocked } from '~/helpers'
  import { TEST_TYPES } from '~/constants'
  import Breadcrumbs from '~/components/breadcrumbs/index'


  export default {
    metaInfo() {
      return { title: 'Lessons' };
    },
    watch: {
    },
    components: {
      'app-breadcrumbs': Breadcrumbs
    },
    computed: mapGetters({
      module: 'module/module',
      lessons: 'lesson/all',
      periodicaltest: 'test/test'
    }),
    data() {
      return {
      };
    },
    methods: {
      isLocked(lesson) {
        return isLocked(lesson)
      },
      isDataEmpty() {
        return _.get(this.lessons, 'length') === 0
      },
      getLessonOptionsRoute (lesson) {
        return getLessonOptionsRoute(lesson)
      },
      getPeriodicalTestRoute () {
        return getPeriodicalTestRoute(this.module)
      },
      isPeriodicalTestOpen () {
        return _.get(this.periodicaltest, 'is_open')
      },
    },
    async mounted () {
      await this.$store.dispatch('module/clear')
      await this.$store.dispatch('lesson/clear')
      await this.$store.dispatch('module/get', {
        id: _.get(this.$route.params, 'module_id')
      });

      await this.$store.dispatch('lesson/fetch', {
        module_id: _.get(this.module, 'id'),
        is_open: 1
      })

      await this.$store.dispatch('test/fetch', {
        module_id: _.get(this.$route.params, 'module_id'),
        type: TEST_TYPES.PERIODICALTEST
      })
    }
  };
</script>
