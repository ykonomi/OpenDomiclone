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
    props: ['mode'],
    data: function (){
        return { 
        }
    },
    created: function (){
        if (this.mode !== 'debug'){
            Echo.join('game')
                .here((users) => {
                    axios.get('/turns/player').then(e => {
                        if (e.data.is_player){
                            this.$store.dispatch('getSupplies').then(() =>{
                                this.$store.dispatch('toNextPhase', 'action');
                                this.$store.dispatch('startActionPhase');
                            });
                            this.$store.dispatch('toNextPhase', 'action');

                        } else {
                            this.$store.dispatch('getSupplies').then(() =>{
                            });
                        }
                    });
                })
                .joining((user) => {
                })
                .leaving((user) => {
                    console.log(user.name + 'がゲームから離れました');
                })
                .listen('TurnChanged', (e) => {
                    this.who_turn = e.turn_id;
                    if (this.my_id == e.turn_id){
                        this.$store.dispatch('toNextPhase', 'action');
                    }
                })

        } else {
            this.$store.dispatch('getSupplies').then(() =>{
                this.$store.dispatch('startActionPhase');
            });
        }
    },
    data: function () {
        return {
        }
    },
    methods: {
    }
}
</script>
