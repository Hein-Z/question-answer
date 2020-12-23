<template>
    <div class="d-flex flex-column align-items-center justify-content-center">

        <a title="Click to vote up answer "
           class=" mt-2 btn  flex flex-column"
           @click="upVote"
        >
            <i class="fas fa-chevron-circle-up fa-1x"></i>
        </a>
        <span class="votes-count">{{ votesCount }}</span>
        <a title="Click to vote down answer "
           class=" mt-2 btn  flex flex-column"
           @click="downVote"
        >
            <i class="fas fa-chevron-circle-down fa-1x"></i>
        </a>


        <best-answer :question="question" :answer="answer"></best-answer>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: ['question', 'answer'],
    data() {
        return {
            votesCount: this.answer.votes_count
        }
    },
    methods: {
        downVote() {
            this._vote(-1);
        },
        upVote() {
            this._vote(1);
        },
        _vote(type) {
            axios.post(`answer/${this.answer.id}/vote`, {vote: type}).then(res => {
                this.votesCount = res.data.votesCount;
            }).catch();
        }
    }

}
</script>
