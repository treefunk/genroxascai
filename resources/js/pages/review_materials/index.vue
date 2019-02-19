<template>
  <div>
    <app-breadcrumbs></app-breadcrumbs>
    <transition name="bounce">
      <h2 v-if="review_materials">Review Materials</h2>
    </transition>
    <transition-group name="zoom" class="row colored-cards">
      <div v-for="review_material in review_materials" :key="review_material.id" class="col-xl-3 col-sm-6 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">{{ review_material.name }}</h5>
            <p class="card-text">{{ review_material.description }}</p>
          </div>
          <div class="card-footer">
            <router-link :to="getReviewMaterialRoute(review_material)" class="btn btn-primary">View
            </router-link>
          </div>
        </div>
      </div>
    </transition-group>
    <transition name="slideRight">
      <p v-if="isDataEmpty()">
        There are no open review material as of the moment
      </p>
    </transition>
  </div>
</template>
<script>

  import { mapGetters } from 'vuex'
  import { getReviewMaterialRoute } from '~/helpers'
  import Breadcrumbs from '~/components/breadcrumbs/index'

  export default {
    metaInfo() {
      return { title: 'Review Materials' };
    },
    watch: {
    },
    components: {
      'app-breadcrumbs': Breadcrumbs
    },
    computed: mapGetters({
      module: 'module/module',
      review_materials: 'review_material/all',
    }),
    data() {
      return {
      };
    },
    methods: {
      isDataEmpty() {
        return _.get(this.review_materials, 'length') === 0
      },
      getReviewMaterialRoute (reviewMaterial) {
        return getReviewMaterialRoute(reviewMaterial, this.module)
      },
    },
    async mounted () {
      await this.$store.dispatch('review_material/clear')
      await this.$store.dispatch('module/get', {
        id: _.get(this.$route.params, 'module_id')
      });
            await this.$store.dispatch('lesson/get', {
        id: _.get(this.$route.params, 'lesson_id')
      });
      await this.$store.dispatch('review_material/fetch', {
        lesson_id: _.get(this.$route.params, 'lesson_id'),
        is_open: 1
      });
    }
  };
</script>
