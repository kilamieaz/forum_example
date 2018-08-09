<template>
    <div class="alert alert-warning alert-flash" role="alert">
        <strong>Success!</strong> {{body}}.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                body: 'Temp for now'
            }
        }
    }
</script>

<style>
    .alert-flash {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>

