<template>
        <div class="container row btn-group" data-toggle="buttons">
                    <card v-for="(card, index) in hands" 
                          :name="card.name" :desc="card.desc" 
                        :type="card.type" :cost="card.cost" :key="index" :value="index" @action="action">
                    </card>
        </div>
</template>
<script>
export default {
    created: function(){
        //アクションカードがあるかを調べる
        this.hands = [];
        axios.get('/action_phase/exist')
            .then(res => {
                //アクションカードがある場合、アクションフェイズに移行
                if (res.data.result){
                    axios.get('/action_phase/hands')
                        .then(res => {
                            var action_n = res.data.action_n;
                            for (var idx in res.data.ui){
                                this.hands.push(res.data.ui[idx]);
                            }
                        });
                    this.$emit('update_log', "アクションカードを選択してね。");
                } else {
                    this.$emit('update_log', "アクションカードがないため、フェイズを飛ばします。");
                    this.$emit('phase_end');
                }
            });
    },
    data: function(){
        return {
            hands: [],
            action_n: 1,
        }
    },
    methods : {
        action: function(index){
            axios.get('/action_phase/is_action/', {params: {idx : index}})
                .then(res => {
                    if (res.data.result){
                        axios.get('/action_phase/action', {params: {idx : index}})
                            .then(res => {
                                this.$emit('update_log', "アクションカードをプレイします。");
                                this.$emit('phase_end');
                            });


                    } else {
                        this.$emit('update_log', "それはアクションカードではありません。");
                    }
                });
            
        },
    },
}
</script>

<style scoped>
</style>
