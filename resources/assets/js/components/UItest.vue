<template>
<p>
<transition appear name="log" >
<b v-show="show">
 アクションカードがないため、フェイズを飛ばします。<br />
 アクションカードを選択してね。<br />
 それはアクションカードではありません。<br />
 アクションカードを使用します。<br />
 購入するカードを選択してください。<br />
 そのカードは高くて買えません。<br />
 財宝カードを選択してください<br />
 コインがたりません<br />
 カードを購入致しました。<br />
</b>
</transition>
<button text="a" @click="a"></button>
</p>
</template>

<script>
export default {
    data: function () {
        return {
            show: false,
        }
    },
    methods: {
        a: function (event) {
            this.show = true;
        }
    }
}
</script>
<style scoped>
body {
  padding: 2em 5em;
  font: normal 40px/50px Arial, sans-serif;
  color: #999;
}
p {
  height: 50px;
  float: left;
  margin-right: 0.3em;
}
b {
  float: left;
  overflow: hidden;
  position: relative;
  height: 50px;
}

.log-enter-active {
color: #ffffff;
position: relative;
white-space: nowrap;
top: 0;
left: 0;
animation: log-in .5s;
animation-iteration-count: infinite;
animation-delay: 1s;

}

@keyframes log-in {
0%  { top: 0px; }
10% { top: -50px; }
20% { top: -100px; }
30% { top: -150px; }
40% { top: -200px; }
50% { top: -250px; }
80% { top: -300px; }
}
</style>
