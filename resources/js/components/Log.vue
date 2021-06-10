<template>
    <div class="panel panel-warning" >
        <div class="panel-body">
            <span class="typewrite" :period="500"></span>
            <span class="wrap">
                <textarea :value="this.$store.getters.log" rows="1" class="form-control big" id="id" readonly></textarea>
            </span>
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
body {
  background-color:#5492cf;
/* background-color:#ce3635; */
  text-align: center;
  color:#fff;
  padding-top:10em;
}

.big {font-size:32pt;}
.wrap { border-right: 0.08em solid #fff}

/* * { color:#fff; text-decoration: none;} */
</style>
