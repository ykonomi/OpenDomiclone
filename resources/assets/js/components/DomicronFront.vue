<template>
<div>
    <user-input :log="log" @update_log="update_log" :my_id="my_id" :start_id="start_id"></user-input>
    <system-log :log="log"></system-log>
    <debug></debug> 
</div>
</template>

<script>
export default {
    props: ['my_id', 'start_id'],
    data: function () {
        return {
            log: ""
        }
    },
    methods: {
        update_log: function (message) {
            this.log = message;
        },
    }
}
</script>
