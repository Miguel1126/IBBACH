<script>
    import DataTable from '../../components/DataTable.vue';
import { handleErrors } from '../../js/handle_error';
export default {
    mounted() {
        this.getRates(1, true);
    },
    data() {
        return {
            rates: [],
            pay: {
                price: null,
                tuition: ''
            },
            paginationLinks: [],
            editing: false
        }
    },
    methods: {
        async handleSubmit() {
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
                handleErrors(error)
            }
        },
        async getRates(pageNumber, firstRates = false) {
            if(firstRates) this.rates[0] = 'loading'
            if(typeof(pageNumber) == 'string'){
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getTarifas?page=' + pageNumber)
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.rates = response.data.data;
                        this.paginationLinks = response.data.links
                    }
                    else {
                        this.rates[0] = 'error'
                    }
                }
            }
            catch (error) {
                handleErrors(error)
                this.rates[0] = 'error'
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
        deleteRate(id) {
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
    },
    components: {DataTable}


}

</script>
<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">Registro de cuotas</h1>
        <section class=" p-3 ">
            <form @submit.prevent="handleSubmit">
                <h3 class="h1 fw-semibold">Listado de cuotas registradas</h3>
                <div class="input-group input-group-lg w-25">
                    <span class="input-group-text" id="inputGroup-sizing-lg"><i
                            class="material-icons">local_atm</i></span>
                    <input type="text" class="form-control" v-model="pay.price" aria-label="Sizing example input"
                        aria-describedby="inputGroup-sizing-lg" placeholder="Escribir precio">
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
                    <button type="button" class="btn btn-primary btn-lg" @click="handleSubmit">Agregar <i
                            class="material-icons m-auto">add_box</i></button>
                    <button type="button" class="btn btn-warning btn-lg ms-4" @click="clearDropdown">Limpiar <i
                            class="material-icons m-auto">backspace</i></button>
                </div>
            </form>
        </section>
        <section class="p-3">
            <DataTable title="Listado de cuotas" :headers="[
                {title:'Id'},
                {title:'Precio'},
                {title:'Matricula'},
                {title:'Acciones'}
            ]" :items="rates">
                <template #actions>
                    <button type="button" class="btn btn-primary me-2">Modificar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </template>
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                    <ul class="pagination">
                        <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                            v-for="page in paginationLinks" :key="page">
                            <span class="page-link" @click="getRates(page.url)">{{ page.label == 'pagination.previous'
                                    ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                            }}</span>
                        </li>
                    </ul>
                </nav>
        </section>
    </main>
</template>
<style scoped>
.rate {
    border-radius: 20px !important;
}
</style>