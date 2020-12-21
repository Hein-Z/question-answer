<template>
    <a title="Click to mark as favorite question (Click again to undo)"
       class="favourite mt-2  flex flex-column " :class="{favourited:is_favourited,'text-muted':!is_signed_in}"
       @click="favourite"
    >
        <i class="fas fa-star fa-2x"></i>
    </a>
</template>
<script>
import axios from 'axios'

export default {
    props: ['question'],
    data() {
        return {
            is_favourited: this.question.is_favourited,
            is_signed_in: window.Auth.signed_in
        }
    },
    methods: {
        favourite() {
            axios.post(`${this.question.slug}/favourite`).then(res => {
                this.is_favourited = !this.is_favourited;
            }).catch(err => {
                alert('Login first');
            });
        }
    }
    , created() {
    }
}
</script>
