<script>
    export default {
        mounted() {
            this.getRates();
        },
        data() {
            return {
                rates: [],
                pay: {
                    price:null,
                    tuition: ''
                },
                editing: false
            }
        },
        methods: {
            async handleSubmit(){
                try {
                    const response = await this.axios.post('/api/tarifas', this.pay);
                    console.log(response);
                    if (response.status === 201) {
                        this.getRates()
                        this.$swal.fire(
                        'Listo',
                        'Se registro la tarifa',
                        'success'
                        )
                    }
                }
                catch (error) {
                    console.error(error)
                }
            },
             async getRates() {
                try {
                    const response = await this.axios.get('/api/tarifas/get')
                    if (response.status === 200) {
                        if (typeof(response.data) === 'object') {
                            this.rates = response.data
                            console.log(response)
                        }
                        else {
                            console.log(response)
                        }
                    }
                }
                catch (error) {
                    console.error(error) 
                }
            },
            clearDropdown() {
                // Esto hay que rehacerlo

                /* const app = this
                app.pay.rate = []
                app.pay.price = []
                app.pay.tuitSelected = [] */
            },
            validateInput() {
                // Esto hay que rehacerlo

                /* const app = this;
                const valid = app.pay.price.length && app.pay.tuition ? true : false
                return valid */
            },
             deleteRate(id){
                this.rates = this.rates.filter(rate => rate.id != id)
                this.rates = [... this.rates]
            },
            saveEdit() {
                this.editing = false
                //this.clearDropdown()
                this.$swal.fire(
                        'Listo',
                        'Se edito la cuota',
                        'success'
                    )
            },
            confirmDelete(event, id) {
                this.$swal.fire({
                    title: '¿Estas seguro de querer borrar esta cuota?',
                    text: "Si lo borras, no podras recuperarlo",
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
                        'La cuota ha sido eliminado',
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
                <form @submit.prevent="handleSubmit">
                <h3 class="h1 fw-semibold">Listado de cuotas registradas</h3>   
                <div class="input-group input-group-lg w-25">
                        <span class="input-group-text" id="inputGroup-sizing-lg"><i class="material-icons">local_atm</i></span>
                        <input type="text" class="form-control" v-model="pay.price" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Escribir precio">
                </div>
                <br />
                <div>
                    <select class="form-select" v-model="pay.tuition">
                    <option selected>-- --</option>
                    <option value="1">Si</option>
                    <option value="0">No</option>   
                </select>
                </div>
                 <div class="m-4">
                    <button type="button" class="btn btn-primary btn-lg" @click="handleSubmit">Agregar <i class="material-icons m-auto">add_box</i></button>
                    <button type="button" class="btn btn-warning btn-lg ms-4" @click="clearDropdown">Limpiar <i class="material-icons m-auto">backspace</i></button>
                </div>
                </form>
            </section>
             <hr class="separator"/>
        <section class="p-3">
            <div class="table-container p-3 mb-5 bg-body rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Listado de ciclos</h3>
                <table class="table table-bordered border-dark">
                    <thead class="table-info table-bordered border-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Matricula</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="rate in rates" :key="rate.id">
                            <th scope="row">{{ rate.id }}</th>
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