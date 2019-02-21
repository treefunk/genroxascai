<template>
	<div>
    <transition name="slideRight">
      <p v-if="isTestClosed()">
        Pre test is not open as of the moment
      </p>
    </transition>

    <transition name="bounce">
      <div v-if="canStartTest() && !isTakingExam()" class="text-center">
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

    <div v-if="questions" class="card h-100">
  		<div v-if="isTakingExam()">
	    	<h5 class="p-2">Question #{{ getCurrentQuestionIndex() ? getCurrentQuestionIndex() : '' }}
		    <div class="float-right">
			    <button class="btn btn-default" :disabled="isButtonDisable(true)" @click="changeQuestion(true)">
						<fa icon="chevron-left" fixed-width/>
			    	Previous
			    </button>
		    	<button class="btn btn-primary" :disabled="isButtonDisable()" @click="changeQuestion()">
		    		Next
		    		<fa icon="chevron-right" fixed-width/>
		    	</button>
				</div>
	    	</h5>
	    </div>

	    <div v-for="(question, index) in questions" :key="question.id">

	    	
		    <transition name="fade">
		    	<div v-if="isQuestionVisible(question)">
		    		<h6 class="p-2">{{ question.text }}</h6>
		    		<hr>
		    	</div>
		    </transition>
		    <transition name="fade">
			    <div v-if="isQuestionVisible(question)">
   					<div v-for="choice in getChoices(question)" class="p-2">
		    			<input type="checkbox" name="" v-model="choice.is_selected" :checked="choice.is_selected" value="1"> {{ choice.text }}
		    		</div>
			    </div>

		    </transition>
	    </div>
		</div>	
	</div>
</template>
<script>
  import * as _ from 'lodash'
  import { mapGetters } from 'vuex'
  import { TEST_STATUS_TYPES, TEST_TYPES } from '~/constants'
  import { getRandomTransitionName } from '~/helpers'

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
	data () {
		return {
			selected_choice: null
		}
	},
	methods: {
		isButtonDisable (previous = false) {
			const index = _.findIndex(this.questions, {
				id: _.get(this.getCurrentQuestion(), 'id')
			})
			return previous ? index === 0 : index + 1 === _.size(this.questions)
		},
		getCurrentQuestionIndex () {
			const index = _.findIndex(this.questions, {
				id: _.get(this.getCurrentQuestion(), 'id')
			})
			return index + 1
		},
		getCurrentQuestion () {
			return _.find(this.questions, {
				is_visible: true
			})
		},
		changeQuestion (previous = false) {
			this.submitAnswer();

			const index = _.findIndex(this.questions, {
				id: _.get(this.getCurrentQuestion(), 'id')
			});
			console.log('index:', index)

			const toShowIndex = previous ? index - 1 : index + 1
			this.setQuestionVisible(this.questions[toShowIndex])
		},
		submitAnswer () {
			console.log('selected_choice:', this.selected_choice)
		},
		getChoices (question) {
			const choices = _.filter(this.choices, {
				question_id: _.get(question, 'id')
			})
			return choices
		},
		setQuestionVisible (question) {
			_.each(this.questions, question => {
				question.is_visible = false
			})
			this.$forceUpdate();
			setTimeout(() => {
				question.is_visible = true
				this.$forceUpdate();
			}, 550)
		},
		isQuestionVisible (question) {
			return _.get(question, 'is_visible')
		},
		getRandomTransitionName () {
      return getRandomTransitionName()
    },
    isTakingExam () {
    	return _.size(this.questions) > 0
    },
		async takeTest () {
			await this.$store.dispatch('question/fetch', {
		      lesson_id: _.get(this.$route.params, 'lesson_id'),
		      type: this.test_type
		    });

			// set first question visible
			if (_.size(this.questions)) {
				const question = _.first(this.questions)
				this.setQuestionVisible(question)
			}

			await this.$store.dispatch('choice/fetch', {
		      lesson_id: _.get(this.$route.params, 'lesson_id'),
		      type: this.test_type
		    });

			_.each(this.choices, choice => {
				choice.is_selected = false
			})

			
			const startedTest = this.getStartedTest()
			if (startedTest) {
				await this.$store.dispatch('student_answer/get', {
			      test_id: _.get(startedTest, 'id'),
			    });
			}
			this.$forceUpdate();
		},
		getStartButtonText () {
			return (this.isContinuation() ? 'Continue' : ' Start') + this.isPreTest() ? ' Pre Test' : ' Post Test'
		},
		isPreTest () {
			return this.test_type === TEST_TYPES.PRETEST
		},
		isTestClosed () {
			return !_.get(this.test, 'is_open') && this.test
		},
		canStartTest () {
			if (_.isNull(this.user_tests)) {
				return false
			}
			if (_.size(this.user_tests) === 0 && this.user_tests && _.get(this.test, 'is_open')) {
				return true
			}
			const startedTest = this.getStartedTest()
			return !startedTest
		},
		getStartedTest () {
			return _.find(this.user_tests, test => {
				return _.get(test, 'status') === TEST_STATUS_TYPES.STARTED
			})
		},
		isContinuation () {
			return this.getStartedTest() !== undefined
		},
		hasRemainingTry () {
			return _.get(this.test, 'limit') > _.size(this.user_tests)
		}
	},
  async mounted () {
  	await this.$store.dispatch('test/clear')
		await this.$store.dispatch('lesson/clear')
  	await this.$store.dispatch('user_test/clear')
	  await this.$store.dispatch('module/clear')
	  await this.$store.dispatch('question/clear')
	  await this.$store.dispatch('choice/clear')
	  await this.$store.dispatch('student_answer/clear')
	  
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
