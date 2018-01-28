<template>
<div>
<table class="table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="column in columns">
        <th scope="row"> {{ column.id }}</th>
        <td> {{ column.name }} </td>
    </tr>
  </tbody>
</table>
<button class="btn btn-default" @click="show">更新</button>
</div>
</template>

<script>
export default {
    created: function(){
        
    },
    data: function () {
        return {
            header: ['id', 'name', 'created_at', 'updated_at'],
            columns : [],
        }
    },
    methods: {
        show: function(){
            axios.get('/api/users').then(res => {
                for(let i in res.data) {
                    this.columns.push(res.data[i]);
                }
            });
        }
    }
}
</script>

<style scoped>
</style>
