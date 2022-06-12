<script>
    export default {
        data() {
            return {
                rates: [
                    { id: 1, rate: 'cuota', prices: '$16.00',  tuition: 'true' }
                ],
                 rate: null,
                prices: null,
                tuitions: null,
               rate: [
                    { id: 1, rate: 'Cuota' },
                    { id: 2, rate: 'Matricula' },
                    { id: 3, rate: '' }
                ],
                price:[
                     { id: 1, price: '16.00' },
                    { id: 2, price: '50.00' },
                    { id: 3, price: '' }
                ],
                tuition:[
                    {id: 1,  tuition: 'false'},
                    {id: 2,  tuition: 'true'},
                    {id: 3,  tuition: ''}
                ],

                rates:[
                    { id: 1,rate: 'Cuota', price: '16.00',  tuition: 'false'},
                    { id: 2,rate: 'Matricula', price: '50.00',  tuition: 'true'},
                    { id: 3, }
                
                ],
                rates: null,
                prices:null,
                tuitions: null,
                ratSelected: [],
                pricSelected:[],
                tuitSelected: [],
                
            }
        },
        methods: {
            selectrat(event, rate) {
                this.ratSelected = []
                this.ratSelected.push(rate)
            },
            selectpric(event, rate) {
                this.pricSelected = []
                this.pricSelected.push(rate)
            },
            selecttuit(event, rate){
                this.tuitSelected = []
                this.tuitSelected.push(rate)
            },
            clearDropdown() {
                const app = this
                app.ratSelected = []
                app.pricSelected = []
                app.tuitSelected = []
            },
            updateTable() {
                const app = this
                this.rates.push({ id: app.rates.length + 1,  rate: app.rates, price: app.prices, tuition: app.tuitions})
                app.clearDropdown()
            }
            
        }
        
       
    }

</script>
<template>
<main>
    <h1 class="h1 fs-1 fw-bold">Registro de cuotas</h1>
    <section class=" p-3 ">
    <h3 class="h1 fw-semibold">Listado de cuotas registradas</h3>
    <div class="d-flex">
        <div class="m-4">
        <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default">Cuota</span>
  </div>
  <input v-model="rates" placeholder="Escribir cuota" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default">Precio</span>
  </div>
  <input v-model="prices" placeholder="Escribir precio" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default">Matricula</span>
  </div>
  <input v-model="tuitions" placeholder="Escribir matricula" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
                    <br>
                <button type="button" class="d-inline-flex btn btn-outline-primary" @click="updateTable">Agregar<i class="material-icons m-auto">add_box</i></button>
                <button type="button" class="d-inline-flex btn btn-outline-info ms-4"  @click="updateTable">Editar<i class="material-icons m-auto">drive_file_rename_outline</i></button>
                <button type="button"  class=" d-inline-flex btn btn-outline-danger ms-4" @click="updateTable">Eliminar<i class="material-icons m-auto">delete</i></button>
                <button type="button" class=" d-inline-flex btn btn-outline-success ms-4" @click="updateTable">Guardar<i class="material-icons m-auto">save_as</i></button>

            </div>
            </div>
         </section> 
        <br />
         <section class=" p-3 ">
            <h3 class="h3 fw-semibold mb-3">agregar cuota </h3>
            <table class="table table-bordered border-body">
                <thead class="table-success table-bordered border-info">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cuota</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Matricula</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr v-for="rate in rates" :key="rate.id">
                        <th scope="row">{{ rate.id }}</th>
                        <td>{{ rate.rate }}</td>
                        <td>{{rate.price}}</td>
                        <td>{{rate.tuition}}</td>

                    </tr>
                </tbody>
            </table>
        </section>  
        <br> 
         <br>
</main>
</template>
<style scoped>
    .rate {
        border-radius: 20px !important;
    }
    td{
        color: blue;
    }
</style>