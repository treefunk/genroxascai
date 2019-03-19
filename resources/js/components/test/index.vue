<template>
	<div>
		<transition name="rotate">
			<div v-if="isLocked()" class="text-center">
				<h5>This test is locked</h5>
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
	    	<div id="question-nav">
						<button
							v-for="(question, index) in questions" :key="question.id" 
							:class="{ 
								'has-answer': hasAnswer(question), 
								'is-current': getCurrentQuestionIndex() === index + 1 }"
							@click="goToQuestionIndex(index)">
							Q{{ index + 1 }}
						</button>
	    	</div>
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
		    	<p class="text-success">Press the Finish button if you are done taking the test</p>
		    	<button class="btn btn-success btn-lg" @click="finish()">Finish!</button>
		    </div>
			</div>
		</transition>
		<transition name="bounce">
			<div v-if="isShowTestComplete()" class="text-center card p-4">
				<h2 class="text-success">
						{{ show_timesup ? 'Time is Up!' : 'Test Complete!' }}
				</h2>
				<p>{{ getTestResultMessage() }}</p>
				<p v-if="showRecommendationToReview()" class="text-danger">
					You need to rewatch all review materials to retake the test.
				</p>
				<router-link :to="getBackRoute()" class="btn btn-default mb-4">
					Back
        </router-link>
				<div v-if="showRecommendationToReview()">
					<img src="" class="img img-responsive full-width" src="/images/cliparts/retake.svg" />
				</div>
				<div v-if="!showRecommendationToReview()">
					<img src="" class="img img-responsive full-width" src="/images/cliparts/test-complete.svg" style="width: 75%" />
				</div>

			</div>
		</transition>

	</div>
</template>
<script>
	require('howler');
  import moment from 'moment'
  import * as _ from 'lodash'
  import { mapGetters } from 'vuex'
  import { TEST_STATUS_TYPES, TEST_TYPES, USER_TEST_STATUS_TYPES, SOUND_TYPES } from '~/constants'
  import { getRandomTransitionName, getLessonOptionsRoute, getLessonsRoute, playSound } from '~/helpers'

export default {
	props: ['test_type'],
	computed: mapGetters({
	  user: 'auth/user',
	  module: 'module/module',
	  lesson: 'lesson/lesson',
	  user_tests: 'user_test/all',
	  recent_user_test: 'user_test/recent',
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
			show_timesup: false,
			backgroundMusic: new Howl({
	        src: [SOUND_TYPES.TEST_QUESTION],
	        autoplay: false,
	        volume: 0.5,
					loop: true,
	      })
			}
	},
	methods: {
	  isLocked () {
	    return _.get(this.test, 'is_locked')
		},
		showRecommendationToReview() {
			const status = _.get(this.recent_user_test, 'score_status')
			if (status === USER_TEST_STATUS_TYPES.FAILED) {
        const type = _.get(this.test, 'type')
        if (type === TEST_TYPES.PERIODICALTEST) {
          return true
        }
				const failedAttempts = _.get(this.test, 'consecutive_failed_attempts')
				if (type === TEST_TYPES.POSTTEST && failedAttempts >= 2) {
					return true
				}
			}
		},
		getTestResultMessage() {
			const status = _.get(this.recent_user_test, 'score_status')
			if (status === USER_TEST_STATUS_TYPES.PASSED) {
				return 'You passed! ' + _.get(this.recent_user_test, 'score') + '/' + _.size(this.questions)
			}
			return 'You failed! ' + _.get(this.recent_user_test, 'score') + '/' + _.size(this.questions)
		},
		getFlipTransition () {
			this.$forceUpdate
			const currentQuestion = this.getCurrentQuestion()
			if (this.lastQuestionIndex > this.currentQuestionIndex) {
				return 'zoomRight'
			}
			return 'zoomLeft'
		},
		getTimerStart() {
			const userTest = this.getStartedTest()
			const createdAt = _.get(userTest, 'created_at')
			if (!createdAt) {
				return
			}
			const start = moment(createdAt).format("YYYY-MM-DD HH:mm:ss")
			return start
		},
		getTimerEnd() {
			const userTest = this.getStartedTest()
			const createdAt = _.get(userTest, 'created_at')
			if (!createdAt) {
				return
			}
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
			if (!this.getStartedTest()) {
				return
			}
			// fix bug
			if (this.getTimerStart() === this.getTimerEnd()) {
				return
			}
			this.show_timesup = true
			this.finish()
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
			this.backgroundMusic.stop();
			const userTest = await this.$store.dispatch('user_test/finishTest', {
				lesson_id: _.get(this.$route.params, 'lesson_id'),
				module_id: _.get(this.$route.params, 'module_id'),
				type: this.test_type,
				finish: 1,
				id: _.get(this.getStartedTest(), 'id')
			})

			const type = _.get(this.test, 'type')
			const scoreStatus = _.get(this.recent_user_test, 'score_status')
			if (scoreStatus === USER_TEST_STATUS_TYPES.PASSED) {
				if (type === TEST_TYPES.PERIODICALTEST) {
					playSound(SOUND_TYPES.PERIODICAL_TEST_PASSED)
				} else {
					playSound(SOUND_TYPES.TEST_PASSED)
				}
			} else {
				if (type === TEST_TYPES.PERIODICALTEST) {
					playSound(SOUND_TYPES.PERIODICAL_TEST_FAILED)
				} else {
					playSound(SOUND_TYPES.TEST_FAILED)
				}
			}

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
			return this.isAllAnswersSetAndSaved() || this.isPreTest()
		},
		async selectChoice (choice, question) {
			const choices = this.getChoices(question)
			_.each(choices, choice => {
				choice.is_selected = false
				choice.is_saved = false
			})
			choice.is_selected = true

			_.set(question, 'has_answer', true)

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
			this.goToQuestionIndex(toShowIndex)
		},
		goToQuestionIndex(index) {
			this.setQuestionVisible(this.questions[index])
			playSound(SOUND_TYPES.PAGE_FLIP)
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
			}, 700)
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
			this.backgroundMusic.play();
		},
		hasAnswer(question) {
			const questionHasAnswer = _.get(question, 'has_answer')
			if (questionHasAnswer) {
				return true
			}
			const choice = _.find(this.student_answers, {
				question_id: _.get(question, 'id')
			})
			return choice !== undefined
		},
		isPreTest() {
			return this.test_type ===TEST_TYPES.PRETEST
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
		getUserTestCount () {
			return _.size(this.user_tests)
		},
		canStartTest () {
	    if (this.isLocked()) {
	      return false
			}
			if (this.isTestFinished) {
				return false
			}
			if (_.isNull(this.user_tests)) {
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
	destroyed() {
		this.backgroundMusic.stop()
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
<style type="text/css">
	#question-nav {
		margin: 10px;
	}

	#question-nav button {
			background-color: #ec5098;
			width: 50px;
			border: none;
			margin: 0 5px;
	}
	#question-nav button.has-answer {
		background-color: #47e847;
	}
	#question-nav button.is-current {
		border: 2px solid white;
	}
</style>