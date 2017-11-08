<template>
    <label class="btn btn-defalut btn-extend" @click="trigger">
        <input type="checkbox" autocomplete="off"> 
        <div class="offer offer-radius" :class="type">
            <div class="offer-content">
                <h3 class="lead">
                    {{this.name}}
                </h3>
                <p class="wrap">
                {{this.desc}}
                </p>
            </div>
            <div class="shape">
                <div class="shape-text">
                    {{this.cost}}
                </div>
            </div>
        </div>
    </label>
</template>
<script>
export default {
    props: ["name","desc","type","cost","value"],
    methods:{
        trigger : function (event) {
            this.$emit('action', this.value);
            this.$emit('buy1',    this.value);
            this.$emit('buy2',    this.value);
        }
    }

}
</script>
<style scoped>


.shape{	
	border-style: solid; border-width: 30px 0px 0px 70px; float:left; height: 0px; width: 0px;
	-ms-transform:rotate(360deg); /* IE 9 */
	-o-transform: rotate(360deg);  /* Opera 10.5 */
	-webkit-transform:rotate(360deg); /* Safari and Chrome */
	transform:rotate(0deg);
}
.offer{
	background:#fff; border:1px solid #ddd; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); margin: 15px 0; overflow:hidden;
}
.offer-radius{
	border-radius:7px;
}

.coin {	border-color: #FFD700; }
.coin .shape{
	border-color: transparent transparent transparent #FFD700;
	border-color: rgba(255,255,255,0)  rgba(255,255,255,0) rgba(255,255,255,0) #FFD700;
}

.action {	border-color: #C0C0C0; }
.action .shape{
	border-color: transparent transparent transparent #C0C0C0;
	border-color: rgba(255,255,255,0)  rgba(255,255,255,0) rgba(255,255,255,0) #C0C0C0;
}

.action-attack {	border-color: #C0C0C0; }
.action-attack .shape{
	border-color: transparent transparent transparent #C0C0C0;
	border-color: rgba(255,255,255,0)  rgba(255,255,255,0) rgba(255,255,255,0) #C0C0C0;
}
.action-reaction {	border-color: #87CEFA; }
.action-reaction .shape{
	border-color: transparent transparent transparent #87CEFA;
	border-color: rgba(255,255,255,0)  rgba(255,255,255,0) rgba(255,255,255,0) #87CEFA;
}
.curse { border-color: #DA70D6; }
.curse .shape{
	border-color: transparent transparent transparent #DA70D6;
	border-color: rgba(255,255,255,0)  rgba(255,255,255,0) rgba(255,255,255,0) #DA70D6;
}
.vp { border-color: #00EE00; }
.vp .shape{
	border-color: transparent transparent transparent #00EE00;
	border-color: rgba(255,255,255,0)  rgba(255,255,255,0) rgba(255,255,255,0) #00EE00;
}

.shape-text{
	color:#fff; font-size:20px; font-weight:bold; position:relative; right:60px; top:-27px; white-space: nowrap;
	-ms-transform:rotate(30deg); /* IE 9 */
	-o-transform: rotate(30deg);  /* Opera 10.5 */
	-webkit-transform:rotate(30deg); /* Safari and Chrome */
	transform:rotate(0deg);
}	
.offer-content {
	padding:0 20px 10px;
}

.btn-extend {
white-space: normal;
word-wrap: break-word;

}

</style>
