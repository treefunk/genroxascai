<template>
    <div>
            <div class="question" v-for="question in questions" :key="question">
                <div class="form-group">
                    {{ question.text }}
                </div>
                <div v-for="choice in questions.choices" :key="choice">
                    <div class="form-group">
                        {{ choice.text }}
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
    export default {
        props: {
            questions_data: {
                type: Array,
                default: () => []
            }
        },
        data(){
            return {
                questions: this.questions_data
            }
        }
    }
</script>

<style scoped>

</style>