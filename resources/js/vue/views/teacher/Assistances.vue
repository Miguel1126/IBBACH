<script>
    export default {
        data() {
            return {
                date:[
                     { id: 1, date: '' },
                    { id: 2, date: '' },
                    { id: 3, date: '' }
                ],
                	
                assistances:[
                    { id: 1, date: '', statu: 'Presente'},
                    { id: 2, date: '', statu: 'Ausente'},
                    { id: 3, date: '', statu:'Permiso'}
                
                ],
                assistances: [
                    { id: 1, statu: 'Presente' },
                    { id: 2, statu: 'Ausente'},
                    { id: 3, statu: 'Permiso'}
                ],
                dates:null,
                status: null,
                datSelected:[],
                staSelected: [],
                
            }
        },
        methods: {
            },
            selectdat(event, assistance) {
                this.datSelected = []
                this.datSelected.push(assistance)
            },
            selectsta(event, assistance){
                this.staSelected = []
                this.staSelected.push(assistance)
            },
            clearDropdown() {
                const app = this
                app.datSelected =[]
                app.staSelected = []
            },
            updateTable() {
                const app = this
                app.assistances.push({ id: app.assistances.length + 1,  date: app.dates, statu: app.status})
                app.clearDropdown()
            },
           
        }
</script>

<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">Registro de asistencias</h1>
        <br />
        <section class=" p-3 ">
            <div class="d-flex">
            </div>
        </section>
        <section class=" p-3 ">
            <input type="date">
            <br>
            <br>
            <div class="dropdown m-2">
  <button type="button" class="btn btn-primary dropdown-toggle" data-mdb-toggle="dropdown" aria-expanded="false">
    <span v-if="!staSelected.length">Estado</span>
    <span v-else>{{ staSelected[0] }}</span>
  </button>
   <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
    <li v-for="statu in status" :key="statu.id" class="dropdown-item"><button class="text-light" @click="selectSta($event, statu.statu)">{{ statu.statu }}</button></li>
    </ul>
    
</div>
<h3 class="h3 fw-semibold mb-3">Listado de asistencias</h3>
<br>
<table class="table table-bordered table-light border-dark">
<thead class="table-light table-bordered border-dark">
<tr>
<th scope="col">#</th>
<th scope="col">Fecha</th>
<th scope="col">Estado</th>
</tr>
</thead>
<tbody class="table-group-divider">
<tr v-for="assistance in assistances" :key="assistance.id">
<th scope="row">{{ assistance.id }}</th>
<td>{{assistance.date}}</td>
<td>{{assistance.statu}}</td>
<br>
</tr>
</tbody>
</table>
<br>
</section>
</main>    
</template>

<style scoped>
    .assistance {
        border-radius: 15px !important;
    }

    
    th{
        color: black;
    }
    tr{
        color: black
    }
</style>