<template>
  	<div>
  	<app-breadcrumbs></app-breadcrumbs>
  	<transition name="bounce">
      <h2 v-if="lesson">{{ lesson.name }}</h2>
    </transition>
  	<div class="row colored-cards">
  		<transition :name="getRandomTransitionName()">
  		<div v-if="lesson" class="col-xl-4 col-sm-6 mb-3">
            <div class="card bg-white" style="">
                <img height="300" src="/images/cliparts/pre-test.svg" class="card-img-top" alt="...">
                <div class="card-body">
                	<h5 class="card-title">Pre-Test</h5>
                	<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
                <div class="card-footer">
                  <router-link :to="getPreTestRoute()" class="btn btn-danger">View
                  </router-link>
                </div>
            </div>
        </div>
        </transition>
        <transition :name="getRandomTransitionName()">
        <div v-if="lesson" class="col-xl-4 col-sm-6 mb-3">
            <div class="card bg-white" style="">
                <img height="300" src="/images/cliparts/post-test.svg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Post-Test</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
                <div class="card-footer">
                  <router-link :to="getPostTestRoute()" class="btn btn-primary">View
                  </router-link>
                </div>
            </div>
        </div>
        </transition>
        <transition :name="getRandomTransitionName()">
        <div v-if="lesson" class="col-xl-4 col-sm-6 mb-3">
            <div class="card bg-white" style="">
                <img height="300" src="/images/cliparts/review-materials.svg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Review Materials</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
                <div class="card-footer">
                  <router-link :to="getReviewMaterialsRoute()" class="btn btn-warning">View
                  </router-link>
                </div>
            </div>
        </div>
        </transition>
        <!--<transition :name="getRandomTransitionName()">-->
        <!--<div v-if="lesson" class="col-xl-3 col-sm-6 mb-3">-->
            <!--<div class="card bg-white" style="">-->
                <!--<img height="300" src="/images/cliparts/drills.svg" class="card-img-top" alt="...">-->
                <!--<div class="card-body">-->
                    <!--<h5 class="card-title">Drills</h5>-->
                    <!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
                <!--</div>-->
                <!--<div class="card-footer">-->
                  <!--<router-link :to="getDrillsRoute()" class="btn btn-success">View-->
                  <!--</router-link>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
        <!--</transition>-->
  	</div>

  	</div>
</template>

<script>
  import * as _ from 'lodash'
  import { mapGetters } from 'vuex'
  import Breadcrumbs from '~/components/breadcrumbs/index'
  import { getReviewMaterialsRoute, getPreTestRoute, getPostTestRoute, getDrillsRoute, getRandomTransitionName } from '~/helpers'


  export default {
  	components: {
      'app-breadcrumbs': Breadcrumbs
    },
    computed: mapGetters({
      lesson: 'lesson/lesson',
    }),
    methods: {
      getReviewMaterialsRoute () {
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
    },

  }
</script>
