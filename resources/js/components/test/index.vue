<template>
	<div>
	  <transition name="rotate">
      <div v-if="isRecommenedToTakePreviousTest() && !isTestClosed()" class="text-center">
      	<div>
      	<img src="" class="img img-responsive full-width" src="/images/cliparts/retake.svg" />
      		
      	</div>
				<p class="">
					You can still take the previous {{ getTestTypeName() }} Lesson before taking this test
				</p>
				<router-link :to="getBackRoute()" class="btn btn-default">
					Back
        </router-link>
			</div>
    </transition>

    <transition name="slideRight">
      <p v-if="isTestClosed()">
        {{ getTestTypeName() }} is not open as of the moment
      </p>
    </transition>

    <transition name="slideRight">
      <div v-if="maxTriesReached()" class="text-center card p-4">
				<h3 class="">
						You have already taken this test
				</h3>
				<router-link :to="getBackRoute()" class="btn btn-default">
					Back
        </router-link>
			</div>
    </transition>

    <transition name="bounce">

      <div v-if="canStartTest() && !isTakingExam() && !isShowFinishButton()" class="text-center">
        <h4>Press Start when you are ready to take the Test</h4>
        <h6 v-if="getUserTestCount() > 1">
        	You have already taken this exam {{ getUserTestCount() }} times
        </h6>
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
	    	<h6 class="text-righ p-2">
	    		<vue-countdown-timer
			      @end_callback="timeIsUp()"
			      :start-time="getTimerStart()"
			      :end-time="getTimerEnd()"
			      :interval="1000"
			      :end-label="'Time limit'"
			      label-position="begin"
			      :end-text="'Time is up!'"
			      :day-txt="null"
			      :hour-txt="null"
			      :minutes-txt="'minutes'"
			      :seconds-txt="'seconds'"></vue-countdown-timer>
	    	</h6>
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
			    <transition :name="getFlipTransition()">
			    	<div v-if="isQuestionVisible(question)">
			    		<h6 class="p-2">{{ question.text }}</h6>
			    		<hr>
			    	</div>
			    </transition>
			    <transition :name="getFlipTransition()">
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
						{{ show_timesup ? 'Time is Up!' : 'Test Complete!' }}'
				</h2>
				<router-link :to="getBackRoute()" class="btn btn-default">
					Back
        </router-link>
			</div>
		</transition>

	</div>
</template>
<script>
	import moment from 'moment'
  import * as _ from 'lodash'
  import { mapGetters } from 'vuex'
  import { TEST_STATUS_TYPES, TEST_TYPES } from '~/constants'
  import { getRandomTransitionName, getLessonOptionsRoute, getLessonsRoute } from '~/helpers'

export default {

	props: ['test_type'],
	computed: mapGetters({
	  user: 'auth/user',
	  module: 'module/module',
	  lesson: 'lesson/lesson',
	  user_tests: 'user_test/all',
	  test: 'test/test',
	  questions: 'question/all',
	  choices: 'choice/all',
	  student_answers: 'student_answer/all',
	}),
	data () {
		return {
			isTestFinished: false,
			loading: false,
			lastQuestion: null,
			show_timesup: false
		}
	},
	methods: {
		getFlipTransition () {
			this.$forceUpdate
			const currentQuestion = this.getCurrentQuestion()
			console.log(this.lastQuestionIndex, this.currentQuestionIndex)
			if (this.lastQuestionIndex > this.currentQuestionIndex) {
				return 'zoomRight'
			}
			return 'zoomLeft'
		},
		getTimerStart() {
			const userTest = this.getStartedTest()
			const createdAt = _.get(userTest, 'created_at')
			const start = moment(createdAt).format("YYYY-MM-DD HH:mm:ss")
			return start
		},
		getTimerEnd() {
			const userTest = this.getStartedTest()
			const createdAt = _.get(userTest, 'created_at')
			const timeLimit = _.get(this.test, 'time_limit')
			const start = moment(createdAt).format("YYYY-MM-DD HH:mm:ss")
			const end = moment(start).add(timeLimit, 'minutes').format("YYYY-MM-DD HH:mm:ss")
			return end
		},
		timeIsUp () {
			console.log('Timer is up!')
			if (!this.isTakingExam()) {
					return
			}
			this.show_timesup = true
			if (!this.getStartedTest()) {
				return
			}
			this.finish()
		},
		isRecommenedToTakePreviousTest() {
			return _.get(this.test, 'flag_recommended_to_take_previous_test')
		},
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
		getBackRoute () {
			if (_.get(this.test, 'type') === TEST_TYPES.PERIODICALTEST) {
				return getLessonsRoute(this.module)
			}

			return getLessonOptionsRoute(this.lesson)
		},
		async finish () {
			const userTest = await this.$store.dispatch('user_test/finishTest', {
				lesson_id: _.get(this.$route.params, 'lesson_id'),
				module_id: _.get(this.$route.params, 'module_id'),
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
			this.changeQuestion()
			this.$forceUpdate()
		},
		isButtonDisable (previous = false) {
			if (this.loading) {
				return true
			}
			const index = _.findIndex(this.questions, {
				id: _.get(this.getCurrentQuestion(), 'id')
			})
			return previous ? index === 0 : index + 1 === _.size(this.questions)
		},
		getCurrentQuestionIndex () {
			return this.getQuestionIndex(this.getCurrentQuestion())
		},
		getQuestionIndex (question) {
			const index = _.findIndex(this.questions, {
					id: _.get(question, 'id')
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

			this.lastQuestionIndex = index + 1

			const toShowIndex = previous ? index - 1 : index + 1

			if (toShowIndex >= _.size(this.questions)) {
				return
			}
			this.setQuestionVisible(this.questions[toShowIndex])

			var audio = new Audio('/sounds/page-flip.wav');
        audio.play();
		},
		getChoices (question) {
			const choices = _.filter(this.choices, {
				question_id: _.get(question, 'id')
			})
			return choices
		},
		setQuestionVisible (question) {
			this.loading = true
			_.each(this.questions, question => {
				question.is_visible = false
			})
			this.currentQuestionIndex = this.getQuestionIndex(question)

			this.$forceUpdate()
			setTimeout(() => {
				question.is_visible = true
				this.loading = false
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
		      module_id: _.get(this.$route.params, 'module_id'),
		      type: this.test_type
			})
			if (!userTest) {
				console.log('Student should not be able to call this function - takeTest')
				return
			}
			await this.$store.dispatch('question/fetch', {
		      lesson_id: _.get(this.$route.params, 'lesson_id'),
		      module_id: _.get(this.$route.params, 'module_id'),
		      type: this.test_type
		    })

			// set first question visible
			if (_.size(this.questions)) {
				const question = _.first(this.questions)
				this.setQuestionVisible(question)
			}

			await this.$store.dispatch('choice/fetch', {
		      lesson_id: _.get(this.$route.params, 'lesson_id'),
		      module_id: _.get(this.$route.params, 'module_id'),
		      type: this.test_type
		    })

			_.each(this.choices, choice => {
				choice.is_selected = false
			})

			await this.$store.dispatch('student_answer/fetch', {
		      user_test_id: _.get(userTest, 'id')
		    })
			_.each(this.student_answers , studentAnswer => {
				const choice = _.find(this.choices, {
					id: _.get(studentAnswer, 'choice_id')
				})
				choice.is_selected = true
				choice.is_saved = true
			})

			await this.$store.dispatch('user_test/fetch', {
			  lesson_id: _.get(this.$route.params, 'lesson_id'),
			  module_id: _.get(this.$route.params, 'module_id'),
			  type: this.test_type
			})

			this.$forceUpdate()
		},
		getTestTypeName () {
			switch (this.test_type) {
				case TEST_TYPES.PRETEST: return 'Pre Test';
				case TEST_TYPES.POSTTEST: return 'Post Test';
				case TEST_TYPES.PERIODICALTEST: return 'Periodical Test';
			}
			return 'Unknown Test'
		},
		getStartButtonText () {
			return (this.isContinuation() ? 'Continue ' : ' Start ') + this.getTestTypeName()
		},
		isTestClosed () {
			return !_.get(this.test, 'is_open') && this.test
		},
		maxTriesReached() {
			if (!_.get(this.test, 'limit')) {
				return false
			}
			if (_.size(this.user_tests) >= _.get(this.test, 'limit')) {
				if (this.getStartedTest()) {
					return false
				}
				return true
			}
		},
		getUserTestCount () {
			return _.size(this.user_tests)
		},
		canStartTest () {
			if (this.isRecommenedToTakePreviousTest()) {
				return false
			}
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
		  module_id: _.get(this.$route.params, 'module_id'),
		  type: this.test_type
		})
		if (_.get(this.test, 'is_open')) {
			await this.$store.dispatch('user_test/fetch', {
			  lesson_id: _.get(this.$route.params, 'lesson_id'),
			  module_id: _.get(this.$route.params, 'module_id'),
			  type: this.test_type
			})
		}
  }
}
</script>
