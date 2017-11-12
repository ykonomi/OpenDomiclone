<template>
    <div class="panel panel-info">
        <div class="panel-heading">手札：</div>
        <div class="panel-body">
            <div v-for="(card, index) in this.$store.getters.hands" class="btn-group" data-toggle="buttons">
                <card :name="card.name" :desc="card.desc" :type="card.type" 
                      :cost="card.cost" :key="index" :value="card.id"
                      @click="hoge">
                </card>
            </div>
            <button class="btn btn-default"  @click="buy3"> 購入する</button>
        </div>
    </div>
</template>
<script>
export default {
    created: function (){
            this.hands = this.$store.getters.hands,

        console.log("crated");
        console.log(this.$store.getters.hands);
        this.$store.dispatch('getHands');
        console.log("crated");
    },
    updated: function (){
        console.log(this.$store.getters.hands);
    },
    data: function () {
        return {
            phase : this.$store.getters.phase,
            hands : this.$store.getters.hands,
            selected_id : 0
        }
    },
    methods: {
        action: function(index){
            if (this.phase == 'preaction'){
                axios.get('/action_phase/is_action/', {params: {idx : index}})
                    .then(res => {
                        if (res.data.result){
                            axios.get('/action_phase/action', {params: {idx : index}})
                                .then(res => {
                                    this.$emit('update_log', "アクションカードをプレイします。");
                                    this.$emit('update_phase', 'buy');
                                });
                        } else {
                            this.$emit('update_log', "それはアクションカードではありません。");
                        }
                    });
            }
        },
        buy2: function(id){
            if (this.phase == 'buy'){
                if (this.checked_cards.indexOf(id) >= 0){
                    this.checked_cards = this.checked_cards.filter((x) => x !== id);
                } else {
                    this.checked_cards.push(id);
                }
            }
        },
        buy3: function(){
            if (this.phase == 'buy'){
                axios.get('/buy_phase/check', {params: {checks: this.checked_cards,
                    id:     this.selected_id}})
                    .then(res => {
                        if (res.data.result) {
                            axios.get('/buy_phase/buy', 
                                {params: {checks: this.checked_cards, id: this.selected_id}})
                                .then(res => {
                                    this.$emit('update_phase', 'clean');
                                    this.$emit('update_log', "カードを購入致しました");
                                });
                        } else {
                            this.$emit('update_log', "お金がたりません");
                        }
                    });
            }
        },
    }
}
</script>

<style scoped>
</style>
