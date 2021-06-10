<template>
    <div>
        <input type="button" value="init playdata" @click="init"></input>
        <input type="button" value="load session" @click="load_session"></input>
        <div> プレイヤID:{{ id }} </div>
        <div> hands : {{ hand }}</div>
        <div> deck  : {{ deck }}</div>
        <div> discard : {{ discard }}</div>
        <div> play area : {{ play_area }}</div>
        <div> +coin : {{ coin }}</div>
        <div> +action : {{ action_count }}</div>
        <div> +buy : {{ buy_count }}</div>
        <h2> 開発版 - ver 0.95 - </h2>
    </div>
</template>


<script>
export default {
    props: ['name'],
    data: function (){
        return {
            id : 0,
            hand: [],
            deck: [],
            discard: [],
            play_area: [],
            coin: 0,
            action_count: 0,
            buy_count: 0,
        }
    },
    methods: {
        init : function (){
            axios.get('/init_playdata')
                .then(res => {
                    console.log(res);
                });
        },
        load_session : function () {
            axios.all([
                axios.get('/debug/id'),
                axios.get('/debug/hand'),
                axios.get('/debug/deck'),
                axios.get('/debug/discard'),
                axios.get('/debug/playarea'),
                axios.get('/debug/coin'),
                axios.get('/debug/action_counts'),
                axios.get('/debug/buy_counts'),
            ])
            .then(axios.spread((idres, handres, deckres, disres,
                playres, coinres, actionres, buyres) => {
                this.id = idres.data;
                this.hand = handres.data;
                this.deck = deckres.data;
                this.discard = disres.data;
                this.play_area = playres.data;
                this.coin = coinres.data;
                this.action_count = actionres.data;
                this.buy_count = buyres.data;
            }));
        },
    }

}
</script>

<style scoped>
</style>
