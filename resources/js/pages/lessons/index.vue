<template>
  <div>
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
          <router-link :to="getLessonItemsRoute(lesson)" class="btn btn-primary">View
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
  import { getLessonItemsRoute } from '~/helpers'

  export default {
    metaInfo() {
      return { title: 'Lessons' };
    },
    watch: {
    },
    components: {
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
      getLessonItemsRoute (lesson) {
        return getLessonItemsRoute(lesson)
      },
      async loadLessons () {
        await this.$store.dispatch('module/fetchModule', {
          id: _.get(this.$route.params, 'module_id')
        });

        await this.$store.dispatch('lesson/fetchLesson', {
          module_id: _.get(this.module, 'id')
        });
      },
    },
    async created() {
      await this.$store.dispatch('lesson/clear')
    },
    mounted () {
      this.loadLessons();
    }
  };
</script>
