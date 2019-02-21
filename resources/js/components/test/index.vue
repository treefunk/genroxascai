<template>
	<div>

    <transition name="slideRight">
      <p v-if="isTestClosed()">
        Pre test is not open as of the moment
      </p>
    </transition>

    <transition name="slideRight">
      <div v-if="maxTriesReached()" class="text-center card p-4">
				<h3 class="text-info">
						You have already taken this test
				</h3>
				<router-link :to="getLessonOptionsRoute()" class="btn btn-default">
					Back to Lesson
        </router-link>
			</div>
    </transition>

    <transition name="bounce">

      <div v-if="canStartTest() && !isTakingExam() && !isShowFinishButton()" class="text-center">
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

		<transition name="rotate">
	    <div v-if="isTakingExam()" class="card h-100">
	  		<div>
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

		    <div v-for="question in questions" :key="question.id">
			    <transition name="fade">
			    	<div v-if="isQuestionVisible(question)">
			    		<h6 class="p-2">{{ question.text }}</h6>
			    		<hr>
			    	</div>
			    </transition>
			    <transition name="fade">
				    <div v-if="isQuestionVisible(question)">
	   					<div v-for="choice in getChoices(question)" class="p-2" @click="selectChoice(choice, question)">
			    			<input type="radio" :name="'choice-' + question.id" :checked="choice.is_selected" value="1"> {{ choice.text }}
			    		</div>
				    </div>

			    </transition>
		    </div>
		    <div v-if="isShowFinishButton()" class="text-center m-4">
		    	<p class="text-success">You have answered all the questions.
		    	<br>Press the Finish button</p>
		    	<button class="btn btn-success btn-lg" @click="finish()">Finish!</button>
		    </div>
			</div>
		</transition>
		<transition name="bounce">
			<div v-if="isShowTestComplete()" class="text-center card p-4">
				<h2 class="text-success">
						Test Complete!
				</h2>
				<router-link :to="getLessonOptionsRoute()" class="btn btn-default">
					Back to Lesson
        </router-link>
			</div>
		</transition>

	</div>
</template>
<script>
  import * as _ from 'lodash'
  import { mapGetters } from 'vuex'
  import { TEST_STATUS_TYPES, TEST_TYPES } from '~/constants'
  import { getRandomTransitionName, getLessonOptionsRoute } from '~/helpers'

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
			isTestFinished: false
		}
	},
	methods: {
		isShowTestComplete () {
			return this.isTestFinished
		},
		isAllAnswersSetAndSaved () {
			let good = true
			_.each(this.questions, question => {
				const choices = this.getChoices(question)
				const answer = _.find(this.getChoices(question), choice => {
					return _.get(choice, 'is_selected')
				})
				if (!answer) {
					good = false
					return false
				}
			})
			return good
		},
		getLessonOptionsRoute () {
			return getLessonOptionsRoute(this.lesson)
		},
		async finish () {
			const userTest = await this.$store.dispatch('user_test/finishTest', {
				lesson_id: _.get(this.$route.params, 'lesson_id'),
				type: this.test_type,
				finish: 1,
				id: _.get(this.getStartedTest(), 'id')
			})
			const status = _.get(userTest, 'status')
			if (status === TEST_STATUS_TYPES.FINISHED) {
				this.isTestFinished = true
				this.$forceUpdate()
				return
			}
			// if we land here, we have error
			console.log('Something went wrong:', userTest)
		},
		isShowFinishButton () {
			if (!this.isTakingExam()) {
					return false
			}
			return this.isAllAnswersSetAndSaved()
		},
		async selectChoice (choice, question) {
			const choices = this.getChoices(question)
			_.each(choices, choice => {
				choice.is_selected = false
				choice.is_saved = false
			})
			choice.is_selected = true

			const studentAnswer = await this.$store.dispatch('student_answer/set', {
		      question_id: _.get(question, 'id'),
		      choice_id: _.get(choice, 'id')
		    })

			if (studentAnswer) {
				choice.is_saved = true
			}
			this.$forceUpdate()
		},
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
			const index = _.findIndex(this.questions, {
				id: _.get(this.getCurrentQuestion(), 'id')
			})
			const toShowIndex = previous ? index - 1 : index + 1
			this.setQuestionVisible(this.questions[toShowIndex])
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
			this.$forceUpdate()
			setTimeout(() => {
				question.is_visible = true
				this.$forceUpdate()
			}, 550)
		},
		isQuestionVisible (question) {
			return _.get(question, 'is_visible')
		},
		getRandomTransitionName () {
      return getRandomTransitionName()
    },
    isTakingExam () {
    	return _.size(this.questions) > 0 && !this.isTestFinished
    },
		async takeTest () {
			const userTest = await this.$store.dispatch('user_test/takeTest', {
		      lesson_id: _.get(this.$route.params, 'lesson_id'),
		      type: this.test_type
			})
			if (!userTest) {
				console.log('Student should not be able to call this function - takeTest')
				return
			}
			await this.$store.dispatch('question/fetch', {
		      lesson_id: _.get(this.$route.params, 'lesson_id'),
		      type: this.test_type
		    })

			// set first question visible
			if (_.size(this.questions)) {
				const question = _.first(this.questions)
				this.setQuestionVisible(question)
			}

			await this.$store.dispatch('choice/fetch', {
		      lesson_id: _.get(this.$route.params, 'lesson_id'),
		      type: this.test_type
		    })

			_.each(this.choices, choice => {
				choice.is_selected = false
			})

			
			const startedTest = this.getStartedTest()
			if (startedTest) {
				await this.$store.dispatch('student_answer/fetch', {
			      test_id: _.get(startedTest, 'id'),
			    })
			}
			this.$forceUpdate()
		},
		getStartButtonText () {
			return (this.isContinuation() ? 'Continue' : ' Start') + (this.isPreTest() ? ' Pre Test' : ' Post Test')
		},
		isPreTest () {
			return this.test_type === TEST_TYPES.PRETEST
		},
		isTestClosed () {
			return !_.get(this.test, 'is_open') && this.test
		},
		maxTriesReached() {
			if (_.size(this.user_tests) >= _.get(this.test, 'limit')) {
				if (this.getStartedTest()) {
					return false
				}
				return true
			}
		},
		canStartTest () {
			if (this.isTestFinished) {
				return false
			}
			if (_.isNull(this.user_tests)) {
				return false
			}
			if (this.maxTriesReached()) {
				return false
			}
			if (!_.get(this.test, 'is_open')) {
				return false
			}
			return true
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
    })
  	await this.$store.dispatch('lesson/get', {
		  id: _.get(this.$route.params, 'lesson_id')
		})
		await this.$store.dispatch('test/fetch', {
		  lesson_id: _.get(this.$route.params, 'lesson_id'),
		  type: this.test_type
		})
		if (_.get(this.test, 'is_open')) {
			await this.$store.dispatch('user_test/fetch', {
			  lesson_id: _.get(this.$route.params, 'lesson_id'),
			  type: this.test_type
			})
		}
  }
}
</script>
