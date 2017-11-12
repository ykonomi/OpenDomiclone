<template>
<div>
    <div class="row col-md-12">
        <system-log :log="log"></system-log>
        <div class="row">
            <div class="row col-md-6">
                <supply :phase="phase" @update_phase="update_phase" @update_log="update_log"></supply>
            </div>
            <div class="row col-md-6">
                <playarea :phase="phase"@update_phase="update_phase" @update_log="update_log"></playarea>
                <hand :phase="phase"@update_phase="update_phase"@update_log="update_log"></hand>
            </div>
        </div>
        <disposal :phase="phase"@update_phase="update_phase" @update_log="update_log"></disposal>
        <public :phase="phase"@update_phase="update_phase" @update_log="update_log"></public>
    </div>
</div>
</template>

<script>
export default {
    props: ['my_id', 'start_id'],
    created: function (){
        if (this.my_id == this.start_id){
            this.$store.dispatch('toNextPhase', 'action');
            alert("あなたのターンです。");
        } else {
            axios.get('/get_name', {params : {id : this.start_id}})
                .then(res => {
                    this.$emit('update_log', res.data + "のターンです。");
                });
        }
        Echo.channel('channel-name')
            .listen('TurnChange', (e) => {
                this.who_turn = e.turn_id;
                if (this.my_id == e.turn_id){
                    this.$store.dispatch('toNextPhase', 'action');
                }
            })

    },
    data: function () {
        return {
            log: "",
            phase: "start",
        }
    },
    methods: {

        aaa: function(){
            console.log("fff");
        },
        update_log: function (message) {
            console.log(message);
            this.log = message;
        },
        update_phase: function(phase) {
            console.log(phase);
            this.phase = phase;
        },
        clean: function(){
            axios.get('/clean')
                .then(res => {
                    this.turn_end();
                });
        },
        turn_end : function () {
            axios.get('/turn_end',{params: {id : this.who_turn}})
                .then(res => {
                });
        }
    }
}
</script>
