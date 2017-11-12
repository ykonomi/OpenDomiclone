<template>
<div class="popover right show balloon-extend">
    <div class="arrow"></div>
    <div class="popover-content">
       <p>
       {{desc}}
        </p>
    </div>
</div>
</template>

<script>
export default {
    props: ['desc'],
}
</script>

<style scoped>
.balloon-extend {
    position: absolute;
    left: 80px;
    width:200%;
    z-index: 1;
}
</style>
