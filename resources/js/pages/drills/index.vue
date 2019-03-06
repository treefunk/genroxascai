<template>
  <div>
    <app-breadcrumbs></app-breadcrumbs>
    <transition name="bounce">
      <h2 v-if="drills">Drills</h2>
    </transition>
    <transition-group name="zoom" class="row colored-cards">
      <div v-for="drill in drills" :key="drill.id" class="col-xl-3 col-sm-6 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">{{ drill.name }}</h5>
            <p class="card-text">{{ drill.description }}</p>
          </div>
          <div class="card-footer">
            <router-link :to="getDrillRoute(drill)" class="btn btn-primary">View
            </router-link>
          </div>
        </div>
      </div>
    </transition-group>
    <transition name="slideRight">
      <p v-if="isDataEmpty()">
        There are no open Drill as of the moment
      </p>
    </transition>
  </div>
</template>
<script>

  import { mapGetters } from 'vuex'
  import { getDrillRoute } from '~/helpers'
  import Breadcrumbs from '~/components/breadcrumbs/index'

  export default {
    metaInfo() {
      return { title: 'Drills' };
    },
    watch: {
    },
    components: {
      'app-breadcrumbs': Breadcrumbs
    },
    computed: mapGetters({
      module: 'module/module',
      drills: 'drill/all',
    }),
    data() {
      return {
      };
    },
    methods: {
      isDataEmpty() {
        return _.get(this.drills, 'length') === 0
      },
      getDrillRoute (drill) {
        return getDrillRoute(drill, this.module)
      },
    },
    async mounted () {
      await this.$store.dispatch('drill/clear')
      await this.$store.dispatch('module/get', {
        id: _.get(this.$route.params, 'module_id')
      });
            await this.$store.dispatch('lesson/get', {
        id: _.get(this.$route.params, 'lesson_id')
      });
      await this.$store.dispatch('drill/fetch', {
        lesson_id: _.get(this.$route.params, 'lesson_id'),
        is_open: 1
      });
    }
  };
</script>
