<template>
  	<div>
  	<app-breadcrumbs></app-breadcrumbs>
  	<transition name="bounce">
      <h2 v-if="lesson">{{ lesson.name }}</h2>
    </transition>
  	<div class="row colored-cards">
  		<transition :name="getRandomTransitionName()">
  		<div v-if="lesson" class="col-xl-3 col-sm-6 mb-3">
            <div class="card h-100" style="">
                <img height="300" src="/images/cliparts/pre-test.svg" class="card-img-top" alt="...">
                <div class="card-body">
                	<h5 class="card-title">Pre-Test</h5>
                	<p class="card-text">A preliminary test administered to determine a student's baseline knowledge or preparedness for an educational experience or course of study.</p>
                </div>
                <div class="card-footer">
                  <router-link :to="getPreTestRoute()" class="btn btn-danger">View
                  </router-link>
                </div>
            </div>
        </div>
        </transition>
        <transition :name="getRandomTransitionName()">
        <div v-if="lesson" class="col-xl-3 col-sm-6 mb-3">
            <div class="card h-100" :class="{'item-locked': isReviewMaterialsLocked()}">
                <img height="300" src="/images/cliparts/review-materials.svg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Review Materials</h5>
                    <p class="card-text">A recording of moving visual images that show real people, places and things that enable students to learn skills or knowledge.</p>
                </div>
                <div class="card-footer">
                  <router-link :to="getReviewMaterialsRoute()" class="btn btn-primary">View
                  </router-link>
                </div>
            </div>
        </div>
        </transition>
        <transition :name="getRandomTransitionName()">
        <div v-if="lesson" class="col-xl-3 col-sm-6 mb-3">
            <div class="card h-100" :class="{'item-locked': isDrillsLocked()}">
                <img height="300" src="/images/cliparts/drills.svg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Drills</h5>
                    <p class="card-text">Play some educational related games.</p>
                </div>
                <div class="card-footer">
                  <router-link :to="getDrillsRoute()" class="btn btn-warning">View
                  </router-link>
                </div>
            </div>
        </div>
        </transition>
        <transition :name="getRandomTransitionName()">
        <div v-if="lesson" class="col-xl-3 col-sm-6 mb-3">
            <div class="card h-100" :class="{'item-locked': isPostTestLocked()}">
                <img height="300" src="/images/cliparts/post-test.svg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Post-Test</h5>
                    <p class="card-text">A test given to students after completion of an instructional program or segment to measure their achievement and the effectiveness of the program.</p>
                </div>
                <div class="card-footer">
                  <router-link :to="getPostTestRoute()" class="btn btn-success">View
                  </router-link>
                </div>
            </div>
        </div>
        </transition>
  	</div>

  	</div>
</template>

<script>
  import * as _ from 'lodash'
  import { mapGetters } from 'vuex'
  import Breadcrumbs from '~/components/breadcrumbs/index'
  import { getReviewMaterialsRoute, getPreTestRoute, getPostTestRoute, 
    getDrillsRoute, getRandomTransitionName, getReviewMaterialRoute } from '~/helpers'


  export default {
  	components: {
      'app-breadcrumbs': Breadcrumbs
    },
    computed: mapGetters({
      lesson: 'lesson/lesson',
      module: 'module/module',
      review_materials: 'review_material/all',
    }),
    methods: {
      isPostTestLocked() {
        return _.get(this.lesson, 'is_posttest_locked')
      },
      isReviewMaterialsLocked() {
        return _.get(this.lesson, 'is_review_materials_locked')
      },
      isDrillsLocked() {
        return _.get(this.lesson, 'is_drills_locked')
      },
      getReviewMaterialsRoute () {
        if (_.size(this.review_materials) === 1) {
          const reviewMaterial = _.first(this.review_materials)
          return getReviewMaterialRoute(reviewMaterial, this.module)
        }
        return getReviewMaterialsRoute(this.lesson)
      },
      getPreTestRoute () {
        return getPreTestRoute(this.lesson)
      },
      getPostTestRoute () {
        return getPostTestRoute(this.lesson)
      },
      getDrillsRoute () {
        return getDrillsRoute(this.lesson)
      },
      getRandomTransitionName() {
        return getRandomTransitionName()
      }
    },
    data() {
    	return {
    	}
    },
    async mounted () {
      await this.$store.dispatch('lesson/clear')
      await this.$store.dispatch('module/clear')
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
    },

  }
</script>
