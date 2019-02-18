<template>
  <div>
  	<app-breadcrumbs></app-breadcrumbs>
    <p>Pre Test Here</p>
    <p>Post Test Here</p>
    <p>Reviewe Materials Here</p>
    <p>Drills Here</p>
  </div>
</template>

<script>
  import Breadcrumbs from '~/components/breadcrumbs/index'

  export default {
  	components: {
      'app-breadcrumbs': Breadcrumbs
    },

    methods: {
      getLessonItemsRoute (lesson) {
        return getLessonItemsRoute(lesson)
      },
    },
    async mounted () {
      await this.$store.dispatch('lesson/clear')
      await this.$store.dispatch('module/clear')
      await this.$store.dispatch('module/fetchModule', {
        id: _.get(this.$route.params, 'module_id')
      });
      await this.$store.dispatch('lesson/fetchLesson', {
        id: _.get(this.$route.params, 'lesson_id')
      });
    }
  }
</script>