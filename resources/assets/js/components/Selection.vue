<template>
    <div>
        <label>+Coin : </label>
        <select @change="touch">
            <option v-for="element in this.$store.getters.plusBuy">{{element}}</option>
        </select>
    </div>
</template>


<script>
export default {
    data: function () {
        return {
        }
    },
    methods:{ 
        touch: function(){
            this.$emit('trigger');
        },
    },
}
</script>

<style scoped>
</style>
