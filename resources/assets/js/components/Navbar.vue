<template>
    <div>
        <a class="navbar-brand" href="/">
            Domiclone
        </a>

        <span class="navbar-brand" data-toggle="modal" data-target="#processing-modal" @click="join" v-if="auth_child">
            <modal :id="id"  v-if="starting"></modal>
            join
        </span> 

        <!--
        <a class="navbar-brand" href="/start" v-if="auth_child">
            dev-main
        </a>
        <a class="navbar-brand" href="/dev_action" v-if="auth_child">
            dev-action
        </a>
        <a class="navbar-brand" href="/register" v-if="!auth_child">
            Register
        </a>
        -->
    </div>
</template>

<script scoped>
    export default {
        created: function () {
            this.get_id();
        },
        props: ['auth'],
        data : function (){
            return {
                auth_child: this.auth,
                starting: false,
                id: 0,
            }
        },
        methods: {
            join : function(event){
                this.starting = true;
            },
            get_id: function() {
                axios.get('/debug/id')
                    .then(res => {
                        this.id = res.data;
                    });
            },
        }
    }
</script>
