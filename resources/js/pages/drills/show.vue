<template>
	<div class="h-100">
    <app-breadcrumbs></app-breadcrumbs>
    <transition name="bounce">
      <h2 v-if="drill">{{ drill.name }}</h2>
    </transition>
    <transition name="bounce">
      <div v-if="drill && !started" class="text-center mt-4">
        <h6>Instructions:</h6>
        <p>{{ drill.instructions }}</p>
        <button class="btn btn-success mt-4" @click="start()">Start</button>
      </div>
    </transition>
    <div v-if="drill && started">
      <object autoplay="false" width="100%" height="100%" :data="getSrc()"></object>
    </div>
	</div>
</template>
<script>
  import * as _ from 'lodash'
  import { mapGetters } from 'vuex'
  import Breadcrumbs from '~/components/breadcrumbs/index'
  export default {
    components: {
      'app-breadcrumbs': Breadcrumbs
    },
    computed: mapGetters({
      drill: 'drill/drill'
    }),
    data() {
      return {
        started: false
      };
    },
    methods: {
      start() {
        this.started = true
      },
      getType() {
        return this.drill.mime_type
      },
      getSrc() {
        const fileName = _.get(this.drill, 'file_name')
        if (fileName) {
          return '/storage/drills/' + fileName
        }
      },
    },
    async mounted () {
      await this.$store.dispatch('drill/clear')
      await this.$store.dispatch('drill/get', {
        id: _.get(this.$route.params, 'drill_id')
      });
      await this.$store.dispatch('module/get', {
        id: _.get(this.$route.params, 'module_id')
      });
      await this.$store.dispatch('lesson/get', {
        id: _.get(this.$route.params, 'lesson_id')
      });

      if (!_.get(this.drill, 'instructions')) {
        this.start()
      }
    }

  }
</script>
