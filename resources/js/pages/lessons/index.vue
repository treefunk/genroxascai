<template>
  <div>
    <app-breadcrumbs></app-breadcrumbs>
    <transition name="bounce">
      <h2 v-if="lessons">Lessons</h2>
    </transition>
    <transition-group v-if="hasData()" class="row colored-cards" name="rotate">
    <div v-for="lesson in lessons" :key="lesson.id" class="col-xl-3 col-sm-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">{{ lesson.name }}</h5>
          <p class="card-text">{{ lesson.description }}</p>
        </div>
        <div class="card-footer">
          <router-link :to="getLessonOptionsRoute(lesson)" class="btn btn-primary">View
          </router-link>
        </div>
      </div>
    </div>
    </transition-group>
    <transition name="slideRight">
      <p v-if="isDataEmpty()">
        There are no open lesson as of the moment
      </p>
    </transition>
  </div>
</template>
<script>
  import * as _ from 'lodash'
  import { mapGetters } from 'vuex'
  import { getLessonOptionsRoute } from '~/helpers'
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
    }),
    data() {
      return {
      };
    },
    methods: {
      isDataEmpty() {
        return _.get(this.lessons, 'length') === 0
      },
      hasData() {
        return _.size(this.lessons) > 0 
      },
      getLessonOptionsRoute (lesson) {
        return getLessonOptionsRoute(lesson)
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
      });
    }
  };
</script>
