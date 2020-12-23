<template>
    <div>
        <div class="row">
            <div
                class="text-center col-12 h1 font-weight-bolder bg-gray-100">{{ question.answers_count }} Answers
            </div>

            <div class="text-center col-12 h3 font-weight-bolder bg-gray-100">There is no answers yet</div>

            <div class="col-12">
                <form method="post" @submit.prevent="postAnswer">
                    <label for="answer">Enter Your Answer</label>
                    <textarea name="body" class="form-control " v-model="answer" placeholder="Your Answer"
                              id="answer" cols="30" rows="6"
                              style="resize: none"></textarea>
                    <p class="text-danger text-center">{{ feedback }}</p>
                    <button type="submit" class="btn-block btn btn-primary my-1">Post</button>
                </form>
            </div>
        </div>

        <answer v-for="answer in answers" :question="question" :answer="answer" :key="answer.id"></answer>
        <div class="text-center my-2">
            <button class="btn btn-dark" v-if="nextUrl" @click="load">Load more answer</button>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    props: ['question'],
    data() {
        return {
            answer: '',
            questionSlug: this.question.slug,
            answers: [],
            feedback: '',
            nextUrl: ''
        }
    },
    methods: {
        postAnswer() {
            if (this.answer.trim()) {
                axios.post(`${this.questionSlug}/answer`, {body: this.answer}).then(res => {
                    this.answers.unshift(res.data.answer);
                    this.answer = '';
                    this.feedback = '';
                }).catch(err => alert('something wrong'));
            } else {
                this.feedback = 'Cannot be blank';
            }
        },
        fetch(url) {
            axios.get(url).then(res => {
                this.nextUrl = res.data.next_page_url;
                this.answers.push(...res.data.data);
            }).catch(err => console.log(err));
        },
        load() {
            this.fetch(this.nextUrl);
        }
    },
    created() {
        this.fetch(`${this.questionSlug}/answer`);
    }
}
</script>
