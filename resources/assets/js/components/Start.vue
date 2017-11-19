<template>
    <div>
        <modal v-if="modal" :message="message"></modal>
        <div v-if="production">
            <front :my_id="id" :start_id="start_id"></front>
        </div>
        <div v-if="debug">
            <front :my_id="1" :start_id="1"></front>
            <debug></debug>
        </div>
    </div>
</template>

<script>
export default {
    props: ['mode', 'id'],
    data: function () {
        return {
            production: false,
            debug: false,
            modal: false,
            start_id : 0,
            member: 0,
            message: '人数が揃うのを待っています...',
            ids: [],
        }
    },
    created: function (){
        if (this.mode == 'production'){
            this.modal = true;
            this.member++;
            this.ids.push(this.id);
            axios.get('/entry', {params : {id : this.id}})

            Echo.channel('channel-name')
                .listen('OtherEntry', (e) => {
                    this.ids = e.ids;
                    this.member = e.ids.length;

                    if (this.member === 2){
                        this.message = '人数が揃いました!. 初期化中...!';

                        //TODO : 親の決め方 (今は最小のid)
                        this.start_id = Math.min.apply(null, this.ids);

                        if (this.id === this.start_id){
                            //親はゲーム全体の初期化もする
                            axios.get('/init_parent', {params : {id : this.id}})
                                .then(res => {
                                    this.production = true;
                                    this.modal = false;
                                });
                        } else {
                            axios.get('/init_child', {params : {id : this.id}})
                                .then(res => {
                                    this.production = true;
                                    this.modal = false;
                                });
                        }
                    }
                });
        } else if (this.mode == 'debug'){
            axios.all([
                axios.get('/debug/entry', {params : {id : 1}}),
                axios.get('/debug/entry', {params : {id : 2}})
            ]).then(axios.spread((res1, res2) => {
                axios.all([
                    axios.get('/init_parent'),
                ]).then(axios.spread((res) => {
                    this.debug = true;
                }));
            }));
        }
    },
    methods: {
    }
}
</script>

<style scoped>
</style>
