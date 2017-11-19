<template>
    <div class="panel panel-info">
        <div class="panel-heading">手札：</div>
        <div class="panel-body">
            <div v-for="(card, index) in this.$store.getters.hands" class="btn-group"  data-toggle="buttons">
                <card :name="card.name" :desc="card.desc" :type="card.type" 
                      :cost="card.cost" :key="index" :value="index" @trigger="click">
                </card>
            </div>
            <button v-show="this.$store.getters.showNoActionButton" 
                    class="btn btn-default"  @click="noAction"> アクションカードを使用しない</button>
            <button v-show="this.$store.getters.showBuyButton" 
                    class="btn btn-default"  @click="buy"> 購入する</button>
        </div>
    </div>
</template>
<script>
export default {
    created: function (){
    },
    methods: {
        click: function(value){
            switch(this.$store.getters.phase){
                case 'action':
                    this.$store.dispatch('isActionCard', value);
                    break;
                case 'buy':
                    this.$store.commit('appearBuyButton');
                    this.$store.commit('addChecks', value);
                    break;
            }
        },
        noAction: function(){
            this.$store.dispatch('toNextPhase', 'prebuy');
            this.$store.commit('disappearNoActionButton');
        },
        buy: function(){
            this.$store.dispatch('buy');
        }
    }
}
</script>

<style scoped>
</style>
