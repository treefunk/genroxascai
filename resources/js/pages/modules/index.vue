<template>
  <div>
    <div class="row">
      <div v-for="module in modules" class="col-sm-3 mb-4">
        <div class="card">
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
    </div>
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
    mounted () {
      this.loadModules();
    }
  };
</script>
