<template>
<div>
    <div class="row col-md-12">
        <log></log>
        <div class="row">
            <div class="row col-md-6">
                <supply></supply>
            </div>
            <div class="row col-md-6">
                <playarea></playarea>
                <hand></hand>
            </div>
        </div>
        <trash></trash>
        <public></public>
    </div>
</div>
</template>

<script>
export default {
    props: ['my_id', 'start_id'],
    created: function (){
        if (this.my_id == this.start_id){
            this.$store.dispatch('toNextPhase', 'action');
            //alert("あなたのターンです。");
        } else {
            axios.get('/get_name', {params : {id : this.start_id}})
                .then(res => {
                    this.$store.dispatch('updateLog', res.data + 'のターンです。');
                });
        }
        /*
        Echo.channel('channel-name')
            .listen('TurnChange', (e) => {
                this.who_turn = e.turn_id;
                if (this.my_id == e.turn_id){
                    this.$store.dispatch('toNextPhase', 'action');
                }
            })
        */
        this.$store.dispatch('getSupplies').then(() =>{
            this.$store.dispatch('startActionPhase');
        });
    },
    data: function () {
        return {
        }
    },
    methods: {
    }
}
</script>
