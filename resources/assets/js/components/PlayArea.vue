<template>
    <div class="panel panel-success">
        <div class="panel-heading">プレイエリア：</div>
        <div class="panel-body">
         <div v-for="(card, index) in this.$store.getters.playarea" class="btn-group" data-toggle="buttons">
                <card :name="card.name" :desc="card.desc" :type="card.type" 
                      :cost="card.cost" :key="index" :value="index">
                </card>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    data: function () {
        return {
        }
    },
    methods: {
    }
}
</script>

<style scoped>
</style>
