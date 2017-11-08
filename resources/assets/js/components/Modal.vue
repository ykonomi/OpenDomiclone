<template>
<div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h4> {{ message }} {{member}}
                        <button type="button" class="close" style="float: none;" data-dismiss="modal" aria-hidden="true">×</button></h4>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ["id"],
    data: function () {
        return {
            member: 0,
            message: '人数が揃うのを待っています...',
            ids: [],
            logs: [],
            text: '',
            composing: false,
        }
    },
    created: function () {
        this.member++;
        this.ids.push(this.id);
        axios.get('/entry?id=' + this.id)
        .then(res => {
        });
        Echo.channel('channel-name')
            .listen('OtherEntry', (e) => {
                this.ids = e.ids;
                this.member = e.ids.length;

                if (this.member === 2){
                    this.message = '人数が揃いました!';
                    this.message = '初期化中...!';
                    //もっとも小さいidのプレイヤが親となりゲームの初期化を行う
                    var min = Math.min.apply(null, this.ids);

                    //TODO : 親の決め方 (今は最小のid)
                    if (this.id === min){
                        //親はゲーム全体の初期化もする
                        axios.get('/init_parent')
                            .then(res => {
                                location.href="/start?start_id=" + min;
                            });
                    } else {
                        axios.get('/init_child', {params : {id : this.id}})
                            .then(res => {
                                location.href="/start?start_id=" + min;
                            });
                    }
                }
            });

    },

    methods: {
        submit: function (event){
            //空白のとき、IME起動時は送信しない
            if (this.text === '') return;
            if (this.composing) return;
            this.logs.push(this.text);

            //insertChat("me", this.text, 0);
            this.sendMessage(this.text);
            this.text = "";
        },
    }
}

/* axios POST送信コード。うまくいかないので没
        var params = new URLSearchParams();
        params.append('id', this.id);
        axios.post('/entry', params,{ 
            xsrfHeaderName: 'X-CSRF-Token',
            withCredentials: true
        } )
            .then(res => {
                console.log(res);
            })
*/
</script>

<style scoped>
.modal-static { 
    position: fixed;
    top: 50% !important; 
    left: 50% !important; 
    margin-top: -100px;  
    margin-left: -100px; 
    overflow: visible !important;
}
.modal-static,
.modal-static .modal-dialog,
.modal-static .modal-content {
    width: 200px; 
    height: 200px; 
}
.modal-static .modal-dialog,
.modal-static .modal-content {
    padding: 0 !important; 
    margin: 0 !important;
}
.modal-static .modal-content .icon {
}
</style>
