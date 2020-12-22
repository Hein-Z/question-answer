<template>
    <div>
        <a title="Click to mark as favorite Answer (Click again to undo)"
           class="favourite mt-2 flex flex-column "
           v-if="authorize('accept',answer)"
           :class="{'best-answer':is_best_answer}"
           @click="bestAnswer"
        >
            <i class="fas fa-check fa-2x"></i>
        </a>

        <a title="Author accepted this answer"
           class="favourite mt-2 flex flex-column best-answer"
           v-if="is_best_answer && !authorize('accept',answer)"
        >
            <i class="fas fa-check fa-2x"></i>
        </a>
    </div>

</template>
<script>
import axios from 'axios'

export default {
    props: ['question', 'answer'],
    data() {
        return {
            best_answer_id: this.question.best_answer_id,
            is_best_answer: this.answer.is_best_answer,
            is_signed_in: window.Auth.signed_in,
        }
    },
    methods: {
        bestAnswer() {
            axios.post(`${this.question.slug}/acceptBestAnswer/${this.answer.id}`).then(res => {
                this.is_best_answer = !this.is_best_answer;
            }).catch(err => {
                alert('Login first');
            });
        }
    }

}
</script>
