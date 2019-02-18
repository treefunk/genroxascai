<template>
  	<div>
  	<app-breadcrumbs></app-breadcrumbs>
  	
  	<div class="row colored-cards">
  		<transition name="zoomLeft">
  		<div v-if="isReady" class="col-xl-3 col-sm-6 mb-3">
            <div class="card bg-white" style="">
                <img height="300" src="/images/cliparts/pre-test.svg" class="card-img-top" alt="...">
                <div class="card-body">
                	<h5 class="card-title">Pre-Test</h5>
                	<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
        </transition>
        <transition name="rotateDownRight">
        <div v-if="isReady" class="col-xl-3 col-sm-6 mb-3">
            <div class="card bg-white" style="">
                <img height="300" src="/images/cliparts/post-test.svg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Post-Test</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
        </transition>
        <transition name="fadeDownBig">
        <div v-if="isReady" class="col-xl-3 col-sm-6 mb-3">
            <div class="card bg-white" style="">
                <img height="300" src="/images/cliparts/review-materials.svg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Review Materials</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
        </transition>
        <transition name="zoomUp">
        <div v-if="isReady" class="col-xl-3 col-sm-6 mb-3">
            <div class="card bg-white" style="">
                <img height="300" src="/images/cliparts/drills.svg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Drills</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
        </transition>
  	</div>
  	
  	</div>
</template>

<script>
  import Breadcrumbs from '~/components/breadcrumbs/index'

  export default {
  	components: {
      'app-breadcrumbs': Breadcrumbs
    },

    methods: {
      getLessonItemsRoute (lesson) {
        return getLessonItemsRoute(lesson)
      },
    },
    data() {
    	return {
    		isReady: false
    	}
    },
    async mounted () {
      await this.$store.dispatch('lesson/clear')
      await this.$store.dispatch('module/clear')
      await this.$store.dispatch('module/fetchModule', {
        id: _.get(this.$route.params, 'module_id')
      });
      await this.$store.dispatch('lesson/fetchLesson', {
        id: _.get(this.$route.params, 'lesson_id')
      });

      setTimeout(() => {
      	this.isReady = true
      })
    }
  }
</script>