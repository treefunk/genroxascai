<template>
	<div>
	<app-breadcrumbs></app-breadcrumbs>
    <transition name="slideRight">
      <p v-if="isTestClosed()">
        Pre test is not open as of the moment
      </p>
    </transition>

    <transition name="bounce">
      <div v-if="canStartTest()" class="text-center">
        <h4>Press Start when you are ready to take the Test</h4>
     		<div v-if="user.gender === 'female'">
          <img src="" class="img img-responsive full-width" src="/images/cliparts/goodluck-girl.svg" />
        </div>
        <div v-else>
        	<img src="" class="img img-responsive full-width" src="/images/cliparts/goodluck-boy.svg" />
        </div>

        <button v-if="isContinuation()" type="button" class="btn btn-primary btn-lg">Continue Pre Test</button>
        <button v-else type="button" class="btn btn-primary btn-lg">Start Pre Test</button>
      </div>
    </transition>
	</div>
</template>
<script>
  import * as _ from 'lodash'
  import { mapGetters } from 'vuex'
  import { getLessonOptionsRoute } from '~/helpers'
  import { TEST_STATUS_TYPES, TEST_TYPES } from '~/constants'
  import Breadcrumbs from '~/components/breadcrumbs/index'

export default {
	metaInfo() {
	  return { title: 'Pre Test' };
	},
	watch: {
	},
	components: {
	  'app-breadcrumbs': Breadcrumbs
	},
	computed: mapGetters({
	  user: 'auth/user',
	  lesson: 'lesson/lesson',
	  user_tests: 'user_test/all',
	  test: 'test/test',
	}),
	methods: {
		isTestClosed () {
			return !_.get(this.test, 'is_open') && this.test
		},
		canStartTest() {
			if (_.isNull(this.user_tests)) {
				return false
			}
			if (_.size(this.user_tests) === 0 && this.user_tests && _.get(this.test, 'is_open')) {
				return true
			}
			const startedTest = this.getStartedTest()
			return !startedTest
		},
		getStartedTest() {
			return _.find(this.user_tests, test => {
				return _.get(test, 'status') === TEST_STATUS_TYPES.STARTED
			})
		},
		isContinuation() {
			return this.getStartedTest() !== undefined
		},
		hasRemainingTry() {
			return _.get(this.test, 'limit') > _.size(this.user_tests)
		}
	},
  async mounted () {
  	await this.$store.dispatch('test/clear')
		await this.$store.dispatch('lesson/clear')
  	await this.$store.dispatch('user_test/clear')
	  await this.$store.dispatch('module/clear')
	  
    await this.$store.dispatch('module/get', {
      id: _.get(this.$route.params, 'module_id')
    });
  	await this.$store.dispatch('lesson/get', {
		  id: _.get(this.$route.params, 'lesson_id')
		});
		await this.$store.dispatch('test/get', {
		  id: _.get(this.$route.params, 'lesson_id')
		});
		if (_.get(this.test, 'is_open')) {
			await this.$store.dispatch('user_test/fetch', {
			  lesson_id: _.get(this.$route.params, 'lesson_id'),
			  type: TEST_TYPES.PRETEST
			});
		}
  }
}
</script>
