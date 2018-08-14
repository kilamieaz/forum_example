<template>
<div>
    <div v-if="signedIn">
        <div class="form-group">
            <textarea class="form-control" 
                        id="body" 
                        name="body" 
                        placeholder="Have something to say?" 
                        rows="5"
                        required 
                        v-model="body">
            </textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" @click="addReply">Post</button>
        </div>
    </div>
    <p class="text-center" v-else>Please <a href="/login">Sign in</a>to participate in this discussion.</p>
</div>
</template>

<script>
export default {
    props: ['endpoint'],
    data() {
        return {
            body: ''
        };
    },
    computed: {
        signedIn() {
            return window.App.signedIn;
        }
    },
    methods: {
        addReply() {
            axios.post(this.endpoint, { body: this.body })
            .then(({data}) => {
                this.body = '';
                flash('Your reply has been posted.');
                this.$emit('created', data);
            });
        }
    }
}
</script>
