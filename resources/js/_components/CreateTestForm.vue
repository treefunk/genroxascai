<template>
    <div class="d-flex flex-column">
        <form :action="action_url" method="POST" @submit.prevent="validateFields">
            <slot></slot>
            <div class="question" v-for="(question,index) in questions" :key="question.id">
                <button type="button" @click="removeQuestion(index)" class="btn btn-danger"><i class="fa fa-times"></i></button>
                <input type="hidden" :ref="`question_${index}`" :value="question.id" :name="`questions[${index}][id]`">
                <div class="col-md-12">
                    <label for="question">Question</label>
                    <div class="col-md-5 col-md-offset-2">
                        <div class="form-group">
                            
                            <textarea id="" cols="30" rows="5" :class="[{'is-invalid' : question.valid != undefined},'form-control']" v-model="questions[index].text" :name="`questions[${index}][text]`"></textarea>
                        </div>
                    </div>
                Choices:
                <div v-for="(choice,i) in question.choices" :key="choice.id" class="col-md-5 col-md-offset-3">
                    
                    <input type="hidden" :value="questions[index].choices[i].id" :name="`questions[${index}][choices][${i}][id]`">
                    <div class="input-group" >
                        <button type="button" @click="removeChoice(index,i)" class="btn btn-danger"><i class="fa fa-times"></i></button>
                        <input type="text" :class="[{'is-invalid' : questions[index].choices[i].valid != undefined},'form-control']" v-model="questions[index].choices[i].text" :name="`questions[${index}][choices][${i}][text]`">
                        <div class="input-group-append" >
                            <span class="input-group-text" :class="[questions[index].choices[i].is_correct ? 'correct' : 'wrong']" @click="questions[index].choices[i].is_correct = !(questions[index].choices[i].is_correct)">
                                <div>
                                    <input type="checkbox" :value="1" v-model="questions[index].choices[i].is_correct" id="" :name="`questions[${index}][choices][${i}][is_correct]`" >
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
                <button class="btn btn-default" @click="addChoice(index)" type="button">Add Choice</button>
                </div>
            </div>
            <button type="button" @click="addQuestion" class="btn btn-default">Add Question</button>

            <button type="submit" class="btn btn-default">Submit</button>
            </form>
    </div>
</template>

<script>
    export default {
        props: {
            questions_data: {
                type: Array,
                default: () => []
            },
            action_url: String,
            csrf_field: String
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
            },
            addChoice(question_index){
                this.questions[question_index].choices.push(
                    {
                        text: '',
                        is_correct: 0
                    }
                )
            },
            removeQuestion(index){
                this.questions.splice(index,1)
            },
            removeChoice(question_index,choice_index){
                this.questions[question_index].choices.splice(choice_index,1)
            },
            validateFields(e){
                this.questions = this.questions.map(q => {
                    if(q.text == ''){ q.valid = false;}else{ delete q.valid }
                    let choices = q.choices.map(c => {
                        if(c.text == ''){ c.valid = false; }else{ delete c.valid }
                        return c
                    })

                    q.choices = choices

                    return q;
                })

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