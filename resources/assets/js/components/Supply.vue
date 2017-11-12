<template>
    <div class="panel panel-primary">
        <div class="panel-heading">サプライ：</div>
        <div class="panel-body">
            <div class="panel-body"> <div v-for="(card, index) in supplies" class="btn-group" data-toggle="buttons" >
                    <card :name="card.name" :desc="card.desc" :type="card.type" :cost="card.cost" :key="index" :value="card.id" @buy1="buy1">
                    </card>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    created: function (){
        axios.get('/buy_phase/supplies')
            .then(res => {
                for (var idx in res.data.ui){
                    this.supplies.push(res.data.ui[idx]);
                }
            });
    },
    updated: function (){
        console.log(this.phase);
        switch (this.phase) {
            case 'start':
                break;
            case 'preaction':
                break;
            case 'action':
                this.$store.dispatch('toNextPhase', 'start');
                break;
            case 'prebuy':
        console.log("a");
                this.$emit('update_log', "購入するカードを選択してください。");
                break;
            case 'buy':
                break;
            case 'clean':
                break;
        }
    },
    data: function () {
        return {
            phase : this.$store.getters.phase,
            supplies : [],
            selected_id : 0
        }
    },
    methods: {
        buy1: function(id){
                console.log(this.phase);
            if (this.phase == 'prebuy'){
                this.selected_id = id;
                axios.get('/buy_phase/estimate', {params: {id: id}})
                    .then(res => {
                        if (res.data.result){
                            this.$emit('update_phase', 'buy');
                        } else {
                            this.$emit('update_log', "そのカードは高くて買えません。");
                        }
                    });
            }
        },
    }
}
</script>

<style scoped>
</style>
