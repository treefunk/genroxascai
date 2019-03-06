<template>
  <div>
    <transition name="bounce">
      <h2 v-if="modules">Mga Yunit</h2>
    </transition>
    <transition-group name="zoom" class="row colored-cards">
      <div v-for="module in modules" :key="module.id" class="col-xl-3 col-sm-6 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">{{ module.name }}</h5>
            <img style="max-width: 100%;" :src="getImagePath(module)"/>
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
        Wala pang bukas na yunit
      </p>
    </transition>
  </div>
</template>
<script>

  import { mapGetters } from 'vuex'
  import { getLessonsRoute } from '~/helpers'

  export default {
    metaInfo() {
      return { title: 'Yunit' };
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
      getImagePath(module) {
        if (_.get(module, 'file_name')) {
          return '/storage/images/modules/' + _.get(module, 'file_name')
        }
         return '/images/default-image-module.png'
      },
      isDataEmpty() {
        return _.get(this.modules, 'length') === 0
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
