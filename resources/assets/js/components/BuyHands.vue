<template>
    <div>
        <div v-show="is_buy1" class="container row btn-group" data-toggle="buttons" >
                    <card v-for="(card, index) in supplies" :name="card.name" :desc="card.desc" 
                        :type="card.type" :cost="card.cost" :key="index" :value="card.id" @buy1="buy1">
                             {{ card.type }}
                    </card>
        </div>
        <div v-show="is_buy2" class="container row btn-group" data-toggle="buttons" >
                    <card v-for="(card, index) in hands" :name="card.name" :desc="card.desc" 
                        :type="card.type" :cost="card.cost" :key="index" :value="index" @buy2="buy2">
                    </card>
                    <input type="button" value="購入する" @click="buy3"></input>
        </div>
    </div>
</template>
<script>
export default {
    created: function(){
        axios.get('/buy_phase/supplies')
            .then(res => {
                this.$emit('update_log', "購入するカードを選択してください。");

                for (var idx in res.data.ui){
                    this.supplies.push(res.data.ui[idx]);
                }
            });
    },
    data: function(){
        return {
            selected_id: 0,
            supplies: [],
            hands: [],
            checked_cards: [],
            is_buy1: true,
            is_buy2: false,
        }
    },
    methods : {
        buy1: function(id){
            this.selected_id = id;
            axios.get('/buy_phase/estimate', {params: {id: id}})
                .then(res => {
                    if (res.data.result){
                        this.$emit('update_log', "財宝カードを選択してください。");
                        this.is_buy1 = false;
                        this.is_buy2 = true;

                        axios.get('/buy_phase/hands')
                            .then(res => {
                                //var action_n = res.data.action_n;
                                for (var idx in res.data.ui){
                                    this.hands.push(res.data.ui[idx]);
                                }
                            });
                    } else {
                        this.$emit('update_log', "そのカードは高くて買えません。");
                    }
                });
        },
        buy2: function (id) {
            if (this.checked_cards.indexOf(id) >= 0){
                this.checked_cards = this.checked_cards.filter((x) => x !== id);
            } else {
                this.checked_cards.push(id);
            }
        },
        buy3: function(){
            axios.get('/buy_phase/check', {params: {checks: this.checked_cards,
                                                    id:     this.selected_id}})
                .then(res => {
                    if (res.data.result) {
                        axios.get('/buy_phase/buy', 
                            {params: {checks: this.checked_cards,
                                      id:     this.selected_id}})
                            .then(res => {
                                this.$emit('phase_end');
                                this.$emit('update_log', "カードを購入致しました");
                            });
                    } else {
                        this.$emit('update_log', "お金がたりません");
                    }
                });
            
        },
    },
}
</script>


<style scoped>
</style>
