<template>
  <div>
    <transition name="bounce">
      <h2 v-if="modules">Modules</h2>
    </transition>
    <transition-group v-if="hasData()" name="zoom" class="row colored-cards">
      <div v-for="module in modules" :key="module.id" class="col-xl-3 col-sm-6 mb-4">
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
    <transition name="slideRight">
      <p v-if="isDataEmpty()">
        There are no open module as of the moment
      </p>
    </transition>
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
      isDataEmpty() {
        return _.get(this.modules, 'length') === 0
      },
      hasData() {
        return _.size(this.modules) > 0 
      },
      getLessonsRoute (module) {
        return getLessonsRoute(module)
      },
    },
    async mounted () {
      await this.$store.dispatch('module/clear')
      await this.$store.dispatch('module/fetch', {
        is_open: 1
      });
    }
  };
</script>
