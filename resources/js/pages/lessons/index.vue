<template>
  <div>
    <app-breadcrumbs></app-breadcrumbs>
    <transition name="bounce">
      <h2 v-if="lessons">Lessons</h2>
    </transition>
    <transition-group class="row colored-cards" name="rotate">
    <div v-for="lesson in lessons" :key="lesson.id" class="col-sm-3 mb-4">
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
        module_id: _.get(this.module, 'id')
      });
    }
  };
</script>
