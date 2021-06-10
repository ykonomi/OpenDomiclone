<template>
    <div>
        <label>+Coin : </label>
        <select v-model="selected" @change="touch">
            <option v-for="element in this.$store.getters.plusBuy">{{element}}</option>
        </select>
    </div>
</template>


<script>
export default {
    data: function () {
        return {
            selected : 0,
        }
    },
    methods:{ 
        touch: function(){
            this.$emit('trigger', this.selected);
        },
    },
}
</script>

<style scoped>
</style>
