<template>
    <div>
        <input type="button" value="init playdata" @click="init"></input>
        <input type="button" value="load session" @click="load_session"></input>
        <input type="button" value="update session1" @click="update_session1"></input>
        <input type="button" value="update session2" @click="update_session2"></input>
        <div> プレイヤID:{{ id }} </div>
        <div> 手札番号:{{ hand }}</div>
        <div> 山札番号:{{ deck }}</div>
        <div> 捨て札番号:{{ discard }}</div>
        <div> プレイエリア:{{ play_area }}</div>
        <h2> 開発版 - ver 0.80 - </h2>
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
            contents : [],
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
            ])
            .then(axios.spread((idres, handres, deckres, disres, playres) => {
                this.id = idres.data;
                this.hand = handres.data;
                this.deck = deckres.data;
                this.discard = disres.data;
                this.play_area = playres.data;
            }));
        },
        update_session1 : function () {
            axios.get('/debug/update_session1')
                .then(res => {
                    console.log(res.data.updated);
                    axios.get('/debug/update_session2')
                        .then(res => {
                            console.log(res.data.updated);
                        });

                });
        },
        update_session2 : function () {
            axios.get('/debug/update_session3')
                .then(res => {
                    console.log(res.data.updated);
                });
        },
    }

}
</script>

<style scoped>
</style>
