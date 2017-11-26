<template>
    <div class="panel panel-primary">
        <div class="panel-heading">サプライ：</div>
        <div class="panel-body">
            <div v-for="(card, index) in this.$store.getters.supplies" class="btn-group" data-toggle="buttons" >
                <card :name="card.name" :desc="card.desc" :type="card.type" :cost="card.cost" 
                      :key="index" :value="card.id" @trigger="click">
                </card>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    created: function (){
    },
    data: function () {
        return {
            selected_id : 0
        }
    },
    methods: {
        click: function(id){
            switch(this.$store.getters.phase){
                case 'BeforeBuy':
                    this.$store.dispatch('selectCards', id);
                    break;
                case 'Buy':
                    this.$store.dispatch('selectCards', id);
                    break;
            }
        },
    }
}
</script>

<style scoped>
</style>
