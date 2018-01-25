<template>
    <div class="panel panel-danger">
        <div class="panel-heading">廃棄置き場：</div>
        <div class="panel-body">
            <div v-for="(card, index) in this.$store.getters.trashes" class="btn-group" data-toggle="buttons" >
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
        return {}
    },
    methods: {
    }
}
</script>

<style scoped>
</style>
