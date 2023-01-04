<script>
import DataTable from '../../components/DataTable.vue';
import { handleErrors } from '../../js/handle_error';
import LoadingDots from '../../components/LoadingDots.vue';
import { required, decimal, helpers } from '@vuelidate/validators';
import { computed, reactive } from 'vue';
import { useVuelidate } from '@vuelidate/core'
export default {
    mounted() {
        this.getrates(1, true);
        document.title = "IBBACH | Cuotas"
    },
    data() {
        return {
            v$: useVuelidate(),
            price: '',
            Rates: [],
            editing: false,
            loading: false,
            paginationLinks: []
        };
    },
    validations() { 
        const price = helpers.regex(/^[0-9.$]+$/g)
        return {
            price: { required: helpers.withMessage('Este campo es obligatorio', required), alpah3: helpers.withMessage('Este campo solo puede tener numeros', price) }
        }
    },
    methods: {
        clearInputs() {
            this.price = ''
        },
        async updateRate() {
            this.loading = true
            this.v$.$validate()
            
            if (!this.v$.$error) {
                try {
                    const response = await this.axios.put('/api/updateRate',
                        {
                            id: this.id,
                            price: this.price.split("$")[1],
                        })

                    if (response.status === 202) {
                        this.$swal.fire(
                            'Listo',
                            '¡Se actualizó la cuota correctamente!',
                            'success'
                        )
                        this.getrates()
                    }
                } catch (error) {
                    this.$swal.fire(
                        'Error',
                        'Parece que algo salió mal, intentalo de nuevo',
                        'error'
                    )
                    handleErrors(error)
                    this.loading = false
                }
                this.clearInputs()
            }
            this.loading = false
        },
        async getrates() {
            try {
                const response = await this.axios.get('/api/getrates')
                if (response.status === 200) {
                        this.Rates = response.data.map(r => {
                            r.price = `$${r.price}`
                            return r
                        });
                    }
                    else {
                        this.Rates[0] = 'error'
                    }
            }
            catch (error) {
                handleErrors(error)
                this.Rates[0] = 'error'
            }
        },
    },
    components: { DataTable, LoadingDots }
}        
</script>
<template>
    <main>
        <section class="p-3">
            <DataTable title="Cuotas" personalized :headers="[
                { title: 'Precio', value: 'price'},
                {title: 'Modalidad', value: 'group'},
                { title: 'Acciones' }
            ]" :items="Rates">
             <template #actions="item">
                    <button type="button"
                        @click="id = item.item.id; price = item.item.price; "
                        class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#Modal">Modificar</button>
                </template>
            </DataTable>
        </section>
        <section>
            <!-- Modal -->
            <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-dark" id="ModalLabel">Modificar Cuota</h5>
                            <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="d-flex flex-wrap">
                                    <div class="m-3">
                                        <label class="d-inline-block text-dark">Cuota</label>
                                        <input type="text" class="form-control inputs" placeholder="$0.00" v-model="price" />
                                        <div class="d-flex justify-content-center"><span class="text-danger" v-if="v$.price.$error">{{v$.price.$errors[0].$message}}</span></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="d-flex" v-if="!loading">
                                        <button v-if="!editing" @click="updateRate()"
                                            class="d-inline-flex btn btn-primary m-2">Actualizar<span
                                                class="material-symbols-outlined">
                                                update
                                            </span></button>
                                    </div>
                                    <div v-else>
                                        <LoadingDots styles="my-3 mx-5" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<style scoped>

</style>