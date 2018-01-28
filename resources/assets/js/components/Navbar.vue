<template>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div>
                <a class="navbar-brand">
                    Domiclone
                </a>
                <!--
                    <a class="navbar-brand" href="/main" v-if="auth">
                    Join 
                    </a>
                    <a class="navbar-brand" href="/offline" v-if="auth">
                    Debug(Offline)
                    </a>
                    <a class="navbar-brand" href="/test" v-if="auth">
                    UIお試し
                    </a>
                -->
            </div>
        </div>
    </nav>

</template>

<script scoped>
    export default {
        props: ['auth'],
        data : function (){
            return {
            }
        },
        methods: {
        }
    }
</script>
