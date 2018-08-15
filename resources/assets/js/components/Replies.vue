<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>
        <new-reply :endpoint="endpoint" @created="add"></new-reply>
    </div>
</template>

<script>
import Reply from './Reply.vue';
import NewReply from './NewReply.vue';
export default {
    components: { Reply, NewReply },
    data() {
        return {
            dataSet: false,
            items: [],
            endpoint: location.pathname + '/replies'
        }
    },
    created() {
        this.fetch()
    },
    methods: {
        fetch() {
            axios.get(this.url())
            .then(this.refresh);
        },
        url() {
            // return location.pathname + '/replies'
            return `${location.pathname}/replies`;
        },
        refresh({data}) {
            // console.log(data.data);
            this.dataSet = data;
            this.items = data.data;
        },
        
    }
}
</script>
