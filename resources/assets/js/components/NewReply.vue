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
import 'at.js';
import 'jquery.caret';
export default {
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

    mounted() {
        $('#body').atwho({
            at: "@",
            delay: 750,
            callbacks: {
                remoteFilter: function(query, callback) {
                    $.getJSON("/api/users", {name: query}, function(username) {
                        callback(username)
                    });
                }
            }
        })
    },

    methods: {
        addReply() {
            axios.post(location.pathname + '/replies', { body: this.body })
            .catch(error => {
                // console.log('ERROR');
                // console.log(error.response);
                flash(error.response.data, 'danger')
            })
            .then(({data}) => {
                this.body = '';
                flash('Your reply has been posted.');
                this.$emit('created', data);
            });
        }
    }
}
</script>
