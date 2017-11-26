<template>
    <select>
        <option v-for="element in tmp">{{element}}</option>
    </select>
</template>


<script>
export default {
    data: function () {
        return {
            tmp: [1,2,3],
        }
    },
}
</script>

<style scoped>
</style>
