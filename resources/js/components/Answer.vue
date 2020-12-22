<template>
    <div class="col-12 border-dark border-bottom mt-1">
        <div class="row pb-3 pt-1">
            <div class="col-md-1 col-2  px-0">
                <answer-vote :question="question" :answer="answer"></answer-vote>
            </div>
            <div class=" col-md-11 col-10">
                <div v-if="editing">
                    <div class="text-center h2 font-weight-bolder"> Edit Answer</div>
                    <form @submit.prevent="edit" class="form-group"
                          method="post">
                            <textarea class="form-control " v-model="body"
                                      name="body" id="answer"
                                      placeholder="answer"></textarea>
                        <button class="btn  btn-primary my-2"> Edit Answer</button>
                        <button class="btn btn-warning my-2" type="button" @click="editing=false"> Cancel</button>
                    </form>
                </div>
                <div v-if="!editing">
                    <div class="mt-2 text-gray-600 text-dark " style=" word-wrap: break-word;">
                        {{ body }}
                    </div>
                    <div class="flex flex-column mt-4">
                        <div class="flex ">
                            <user-info label="Answered" :model="answer"></user-info>
                        </div>

                        <div class="flex mt-3" v-if="authorize('modify',answer)">
                            <button class="btn btn-primary btn-sm"
                                    @click="editing=true">Edit
                            </button>
                            <button class="btn btn-danger btn-sm ml-1" @click="destory">
                                Delete
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'

export default {
    props: ['answer', 'question'],
    data() {
        return {
            id: this.answer.id,
            votes_count: this.answer.votes_count,
            editing: false,
            questionSlug: this.question.slug,
            body: this.answer.body,
            is_best_answer: this.answer.is_best_answer,
        }
    },
    methods: {
        edit() {
            axios.put(`${this.questionSlug}/answer/${this.id}`, {
                body: this.body
            }).then(res => {
                this.body = res.data.body;
                this.editing = false
            }).catch(err => {
                this.editing = false
            });
        },
        destory() {
            if (confirm('Are you sure?')) {
                axios.delete(`${this.questionSlug}/answer/${this.id}`).then(res =>
                    $(this.$el).fadeOut(500, () => {
                        alert(res.data.message);
                    })
                ).catch();
            }
        }
    },
}
</script>
