<script>
    export default {
        data() {
            return {
                tuitions:[
                    {id: 1,  tuition: 'false'},
                    {id: 2,  tuition: 'true'},
                ],
                rates:[
                    { id: 1,rate: '', price: '',  tuition: 'false'},
                    { id: 2,rate: '', price: '',  tuition: 'true'},
                
                ],
                pay: {
                rate: null,
                price:null,
                tuitSelected: []
                },
                editing: false
            }
        },
        methods: {
            selectTuit(event, tuition){
                this.pay.tuitSelected = []
                this.pay.tuitSelected.push(tuition)
            },
            clearDropdown() {
                const app = this
                app.pay.rate = []
                app.pay.price = []
                app.pay.tuitSelected = []
            },
            validateDropInput() {
                const app = this;
                const valid = app.pay.rate.length && app.pay.price.length && app.pay.tuitSelected ? true : false
                return valid
            },
           updateTable() {
                const app = this
                if (app.validateDropInput()) {
                    app.rates.push({ id: app.rates.length + 1, rate: app.pay.rate, price: app.pay.price, tuition: app.pay.tuitSelected[0]})
                    app.clearDropdown()
                }
                else {
                    const Toast = this.$swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', this.$swal.stopTimer)
                            toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'error',
                        title: 'Debes rellenar todos los campos'
                    })
                }
            },
            selectRate(event, rate, price, tuition) {
                const app = this
                app.editing = true
                app.pay.rate = rate
                app.pay.price = price
                app.pay.tuitSelected = tuition
            },
             deleteRate(id){
                this.rates = this.rates.filter(rate => rate.id != id)
                this.rates = [... this.rates]
            },
            saveEdit() {
                this.editing = false
                this.clearDropdown()
                this.$swal.fire(
                        'Listo',
                        'Se editó la cuota',
                        'success'
                    )
            },
            confirmDelete(event, id) {
                this.$swal.fire({
                    title: '¿Estas seguro de querer borrar esta cuota?',
                    text: "Si lo borras, no podrás recuperarlo",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Borrar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteRate(id)
                    this.$swal.fire(
                        'Listo',
                        'La cuota ha sido eliminad0',
                        'success'
                    )
                }
                })
            },
              setup() {
            document.title = "IBBACH | Cuotas"
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
                   <div class="input-group input-group-lg w-25">
                        <span class="input-group-text" id="inputGroup-sizing-lg"><i class="material-icons">paid</i></span>
                        <input type="text" class="form-control" v-model="pay.rate" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Nueva cuota">
                    </div>
                </div>
                <br />
                <div class="input-group input-group-lg w-25">
                        <span class="input-group-text" id="inputGroup-sizing-lg"><i class="material-icons">local_atm</i></span>
                        <input type="text" class="form-control" v-model="pay.price" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Escribir precio">
                </div>
                <br />
                   <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                <span><i class="material-icons">savings</i></span>
                    <span v-if="!pay.tuitSelected.length">Matrícula</span>
                    <span v-else>{{ pay.tuitSelected[0] }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                    <li v-for="tuition in tuitions" :key="tuition.id" class="dropdown-item"><button class="text-light list-click" @click="selectTuit($event, tuition.tuition)">{{ tuition.tuition }}</button></li> 
                </ul>
                </div>
                 <div class="m-4">
                    <button type="button" class="btn btn-primary btn-lg" @click="updateTable">Agregar <i class="material-icons m-auto">add_box</i></button>
                    <button type="button" class="btn btn-warning btn-lg ms-4" @click="clearDropdown">Limpiar <i class="material-icons m-auto">backspace</i></button>
                </div>
            </section>
             <hr class="separator"/>
        <section class="p-3">
            <div class="table-container p-3 mb-5 bg-body rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Listado de ciclos</h3>
                <table class="table table-bordered border-dark">
                    <thead class="table-info table-bordered border-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Cuota</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Matrícula</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="rate in rates" :key="rate.id">
                            <th scope="row">{{ rate.id }}</th>
                            <td>{{ rate.rate }}</td>
                            <td>{{ rate.price }}</td>
                            <td>{{ rate.tuition }}</td>
                        <td class="d-flex justify-content-center">
                            <button type="button" class="btn btn-primary me-2" @click="selectRate($event, rate.rate, rate.price, rate.tuition)">Modificar</button>
                            <button type="button" class="btn btn-danger" @click="confirmDelete($event, rate.id)">Eliminar</button>
                        </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</template>
<style scoped>
    .rate {
        border-radius: 20px !important;
    }
</style>