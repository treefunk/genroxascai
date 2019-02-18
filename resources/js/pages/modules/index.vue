<template>
  <div>
    <transition name="bounce">
      <h2 v-if="modules">Modules</h2>
    </transition>
    <transition-group name="zoom" class="row colored-cards">
      <div v-for="module in modules" :key="module.id" class="col-sm-3 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">{{ module.name }}</h5>
            <p class="card-text">{{ module.description }}</p>
          </div>
          <div class="card-footer">
            <router-link :to="getLessonsRoute(module)" class="btn btn-primary">View
            </router-link>
          </div>
        </div>
      </div>
    </transition-group>
  </div>
</template>
<script>

  import { mapGetters } from 'vuex'
  import { getLessonsRoute } from '~/helpers'

  export default {
    metaInfo() {
      return { title: 'Modules' };
    },
    watch: {
    },
    components: {
    },
    computed: mapGetters({
      modules: 'module/all',
    }),
    data() {
      return {
      };
    },
    methods: {
      getLessonsRoute (module) {
        return getLessonsRoute(module)
      },
      async loadModules () {
        await this.$store.dispatch('module/fetchModule');
      },
    },
    async created() {
      await this.$store.dispatch('module/clear')
    },
    mounted () {
      this.loadModules();
    }
  };
</script>
