<template>
<h1>
    <span class="typewrite" :period="500"></span>
    <span class="wrap">
        {{content}}
    </span>
</h1>
<!--        <p>
        <div id="talkField" class="container">
            <div id="result"></div>
            <br class="clear_balloon"/>
            <div id="end"></div>
        </div>
        <div> {{who_turn}}のターンです </div>
        <div class='user'>{{log.user}}</div>
        <div class='left_balloon'>{{log.message}}</div>
        </p>
    </div>
-->
</template>

<script>
export default {
    props: ['log'],
    created: function () {

        this.tick();
        //setTimeout(function () { this.tick() }.bind(this), 1000);
    },
    data: function () {
        return {
            loopNum: 0,
            period: 500,
            isDeleting: false,
            txt : "",
            content: "",
        }
    },
    methods: {
        tick : function () {
            var fullTxt = this.log;

            if (this.isDeleting) {
                this.txt = fullTxt.substring(0, this.txt.length - 1);
            } else {
                this.txt = fullTxt.substring(0, this.txt.length + 1);
            }

            this.content = this.txt;
            
            var delta = 200 - Math.random() * 100;

            if (this.isDeleting) { delta /= 2; }

            if (!this.isDeleting && this.txt === fullTxt) {
                delta = this.period;
                this.isDeleting = true;
            } else if (this.isDeleting && this.txt === '') {
                this.isDeleting = false;
                this.loopNum++;
                delta = 500;
            }

            setTimeout(function () {
               this.tick(); 
            }.bind(this), delta);
        }
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

.wrap { border-right: 0.08em solid #fff}

/* * { color:#fff; text-decoration: none;} */
</style>
