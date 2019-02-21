<template>
	<div>
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

        <button @click="takeTest()" type="button" class="btn btn-primary btn-lg">
        {{ getStartButtonText() }} </button>
      </div>
    </transition>
	</div>
</template>
<script>
  import * as _ from 'lodash'
  import { mapGetters } from 'vuex'
  import { TEST_STATUS_TYPES, TEST_TYPES } from '~/constants'

export default {
	props: ['test_type'],
	computed: mapGetters({
	  user: 'auth/user',
	  lesson: 'lesson/lesson',
	  user_tests: 'user_test/all',
	  test: 'test/test',
	  questions: 'question/all',
	  choices: 'choice/all',
	  student_answer: 'student_answer/all',
	}),
	methods: {
		async takeTest() {
			await this.$store.dispatch('question/fetch', {
		      lesson_id: _.get(this.$route.params, 'lesson_id'),
		      type: this.test_type
		    });

			await this.$store.dispatch('choice/fetch', {
		      lesson_id: _.get(this.$route.params, 'lesson_id'),
		    });
			const startedTest = this.getStartedTest()
			if (startedTest) {
				await this.$store.dispatch('student_answer/get', {
			      test_id: _.get(startedTest, 'id'),
			    });
			}
		},
		getStartButtonText() {
			return (this.isContinuation() ? 'Continue' : ' Start') + this.isPreTest() ? ' Pre Test' : ' Post Test'
		},
		isPreTest() {
			return this.test_type === TEST_TYPES.PRETEST
		},
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
			  type: this.test_type
			});
		}
  }
}
</script>
