<template>
    <form :action="action_url" method="POST" @submit.prevent="validateFields">
        <div class="form-group row">
            <div class="col-4">
                <label for="passing_grade">Passing grade percentage</label>
                <input type="number" class="form-control" min="1" max="99" name="passing_grade" id="passing_grade" v-model="passing_grade">
            </div>
            <div class="col-4">
                <label for="limit">The maximum number of tries</label>
                <input type="number" class="form-control" min="1" max="99" name="limit" id="limit" v-model="limit">
            </div>
            <div class="col-4">
                <label for="is_open">Test is {{ is_open ? 'open' : 'closed' }}</label><br>
                <label class="switch">
                    <input type="checkbox"
                           id="is_open"
                           name="is_open"
                           v-model="is_open"
                           value="1"
                           >
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
        <slot></slot>
        <div class="row" v-for="(question,index) in questions" :key="question.id">
            <input type="hidden" :ref="`question_${index}`" :value="question.id" :name="`questions[${index}][id]`">
            <div class="col-xl-12 col-sm-12 mb-3">
                <div class="card o-hidden h-100">
                    <div class="card-header">
                        <h5>
                            <button type="button" @click="removeQuestion(index)" class="btn btn-danger float-right"><i class="fa fa-times"></i></button>
                            <button type="button" class="btn btn-link" data-toggle="collapse" :data-target="`#question_${index}`" aria-expanded="true"
                            aria-controls="collapseOne">
                            Question {{ index + 1 }}
                            </button>
                        </h5>
                    </div>
                    <div :id="`question_${index}`" class="collapse" aria-labelledby="headingOne" data-parent="">
                        <!-- START CARD BODY -->
                        <div class="card-body">

                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Question</label>
                                <div class="col-sm-10">
                                    <textarea rows="2" :class="[{'is-invalid' : question.valid != undefined  && !questions[index].text},'form-control']" v-model="questions[index].text" :name="`questions[${index}][text]`"></textarea>
                                </div>
                            </div>

                            <div class="form-group row" v-for="(choice,i) in question.choices" :key="choice.id">

                                <input type="hidden" :value="questions[index].choices[i].id" :name="`questions[${index}][choices][${i}][id]`">

                                <div class="col-2">
                                    Choice
                                </div>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <textarea rows="1" aria-label="Text input with checkbox" :class="[{'is-invalid' : questions[index].choices[i].valid != undefined && !questions[index].choices[i].text },'form-control']" v-model="questions[index].choices[i].text" :name="`questions[${index}][choices][${i}][text]`"></textarea>
                                        <div class="input-group-append text-white">
                                            <div :title="questions[index].choices[i].is_correct ? 'This is a correct answer' : ''" class="text-white" :class="[questions[index].choices[i].is_correct ? 'bg-success' : '','input-group-text']" @click="questions[index].choices[i].is_correct = !(questions[index].choices[i].is_correct)">
                                                <input class="d-none" type="checkbox" :value="1" v-model="questions[index].choices[i].is_correct" id="" :name="`questions[${index}][choices][${i}][is_correct]`">
                                                <i v-if="questions[index].choices[i].is_correct" class="fas fa-fw fa-check"></i>
                                                <i v-if="!questions[index].choices[i].is_correct" class="fas fa-fw"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button v-if="isShowRemoveChoice(index)" type="button" @click="removeChoice(index,i)" class="btn btn-danger"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8">
                                    <button class="btn btn-primary" @click="addChoice(index)" type="button">Add Choices</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- END CARD BODY -->

                </div>
            </div>
        </div>
        <button type="button" @click="addQuestion" class="btn btn-primary">Add Question</button>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</template>

<script>
import * as _ from 'lodash';
    export default {
        props: {
            questions_data: {
                type: Array,
                default: () => []
            },
            action_url: String,
            csrf_field: String,
            limit: Number,
            passing_grade: Number,
            is_open: Number
        },
        data(){
            return {
                questions: this.questions_data
            }
        },
        methods: {
            addQuestion(){
              this.questions.push(
                  {
                      text:'',
                      choices: [
                          { text: '', is_correct: 1 },
                          { text: '', is_correct: 0 },
                      ]
                  }
              )
              this.$nextTick(() => {
                  let index = this.questions.length-1
                  $(`#question_${index}`).collapse()
              })
            },
            addChoice(question_index){
              this.questions[question_index].choices.push(
                  {
                      text: '',
                      is_correct: 0
                  }
              )
            },
            removeQuestion (index) {
                this.questions.splice(index, 1)
            },
            removeChoice (question_index, choice_index) {
                this.questions[question_index].choices.splice(choice_index,1)
            },
            isShowRemoveChoice (question_index) {
              return _.size(this.questions[question_index].choices) > 2
            },
            validateFields (e) {
              let missing_fields = 0;
              let hasError = false;
              this.questions = this.questions.map(question => {
                  if (question.text == '') {
                    question.valid = false;
                    missing_fields++
                  } else {
                    delete question.valid
                  }
                  let choices = question.choices.map(choice => {
                    if (choice.text == '') {
                      choice.valid = false;
                      missing_fields++
                    } else {
                      delete choice.valid
                    }
                    return choice
                  })
                  question.choices = choices
                  const correctAnswers = _.filter(question.choices, choice => {
                    return _.get(choice, 'is_correct')
                  })
                  if (_.isEmpty(correctAnswers)) {
                    hasError = true
                    const index = _.findIndex(this.questions, {
                      id: _.get(question, 'id')
                    })
                    alert('There should be atleast one correct answer for Question #' + (index + 1))
                  }
                  return question;
              })

              if (!missing_fields && !hasError) {
                  e.target.submit();
              }
            }
        }
    }
</script>

<style scoped>
.correct {
    background: green;
}
.wrong{
    background: red;
}
input[type=checkbox]{
    width:35px;
    appearance: none;
}
</style>
