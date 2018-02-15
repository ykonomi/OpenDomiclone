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
    created: function (){
        if (this.mode !== 'debug'){
            Echo.join('game')
                .here((users) => {
                    this.$store.dispatch('start');
                })
                .joining((user) => {
                })
                .leaving((user) => {
                    console.log(user.name + 'がゲームから離れました');
                })
                .listen('TurnChanged', (e) => {
                    this.$store.dispatch('start');
                })
        } else {
            axios.post('/users').then(res => {
                this.$store.dispatch('getSupplies').then(() =>{
                    this.$store.dispatch('startActionPhase');
                });
            });
        }
    }
}
</script>

