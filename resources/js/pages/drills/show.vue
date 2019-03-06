<template>
	<div class="h-100">
    <app-breadcrumbs></app-breadcrumbs>
    <transition name="bounce">
      <h2 v-if="drill">{{ drill.name }}</h2>
    </transition>
    <object autoplay="false" width="100%" height="100%" :data="getSrc()"></object>

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
      drill: 'drill/drill',
    }),
    methods: {
      getType() {
        return this.drill.mime_type
      },
      getSrc() {
        return '/storage/drills/' + _.get(this.drill, 'file_name')
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
    }

  }
</script>
