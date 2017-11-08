<template>
    <div>
        <action-hands v-if="is_action" @phase_end="action_end" @update_log="update_log"></action-hands>
        <buy-hands v-if="is_buy" @phase_end="buy_end" @update_log="update_log"></buy-hands>
    </div>
</template>

<script>
export default {
    props: ['my_id', 'start_id', 'log'],
    created: function (){
        if (this.my_id == this.start_id){
            this.is_action = true;
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
                    this.is_action = true;
                }
            })
    },
    data: function(){
        return {
            who_turn: this.start_id,
            is_action: false,
            is_buy:    false,
        }
    },
    methods : {
        update_log: function (log) {
            this.$emit('update_log', log);   
        },
        action_end: function () {
            this.is_action = false;
            this.is_buy = true;
        },
        buy_end: function () {
            this.is_buy = false;
            this.clean();
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
        
    },
}
</script>


<style scoped>
</style>
