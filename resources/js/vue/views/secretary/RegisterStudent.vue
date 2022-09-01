<script>
import DataTable from '../../components/DataTable.vue';

export default {
    mounted() {
        document.title = 'IBBACH | Registro de estudiantes'
        this.getApplicants()
    },
    data() {
        return {
            applicants: [],
            applicant: {},
        }
    },
    methods: {
        async getApplicants() {
            this.applicants[0] = 'loading'
            try {
                const response = await this.axios.get('/api/aplicantes-pendientes')
                if (response.status === 200) {
                    this.applicants = response.data
                }
                else {
                    this.applicants[0] = 'error'
                }
            }
            catch (error) {
                console.log(error)
                this.applicants[0] = 'error'
            }
        },
        showApplicant(applicant) {
            this.applicant = {}
            this.applicant = applicant.item
        }
    },
    components: { DataTable },
}
</script>
<template>
    <section>
        <div class="modal fade text-black text-opacity-75" id="applicantModal" tabindex="-1" aria-labelledby="applicantModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-3" id="staticBackdropLabel">Detalle del aplicante</h5>
                        <button type="button" class="btn btn-danger text-light d-flex justify-content-center"
                            data-bs-dismiss="modal" aria-label="Close"><span
                                class="material-icons">close</span></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="fs-4 fw-bold">Información Personal</h5>
                        <div class="field w-100 mb-2">
                            <label><b>Nombre completo: </b>{{ applicant.name }} {{ applicant.last_name }}</label>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Fecha en que aplicó: </b>{{ applicant.registration_date }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Telefono: </b>{{ applicant.phone }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Correo Electrónico: </b>{{ applicant.email }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Dirección: </b>{{ applicant.address }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Fecha de nacimiento: </b>{{ applicant.birth_date }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Nacionalidad: </b>{{ applicant.nationality }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Estado civíl: </b>{{ applicant.marital_status }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row" v-if="applicant.mate_name">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Nombre del conyuge: </b>{{ applicant.mate_name }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Grado secular: </b>{{ applicant.secular_degree }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Ocupación actual: </b>{{ applicant.current_ocupation }}</label>
                            </div>
                        </div>
                        <hr />
                        <h5 class="fs-4 fw-bold">Información Eclesiastica</h5>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Es pastor: </b>{{ applicant.is_pastor ? 'Si' : 'No' }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Es miembro: </b>{{ applicant.is_member ? 'Si' : 'No' }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row" v-if="applicant.is_member">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Nombre del pastor: </b>{{ applicant.pastor_name }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row" v-if="applicant.is_member">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Teléfono del pastor: </b>{{ applicant.pastor_phone }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row" v-if="applicant.is_member">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Licencia del pastor: </b>{{ applicant.licence }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Iglesia a la que pertenece: </b>{{ applicant.church_name }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Dirección de la iglesia: </b>{{ applicant.church_address }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Teléfono de la iglesia: </b>{{ applicant.church_phone }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Distrito: </b>{{ applicant.district }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Pastor de referencia 1: </b>{{ applicant.reference_name_one }}</label>
                                <label class="ms-2"><b>Teléfono: </b>{{ applicant.reference_phone_one}}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Pastor de referencia 2: </b>{{ applicant.reference_name_two }}</label>
                                <label class="ms-2"><b>Teléfono: </b>{{ applicant.reference_phone_two}}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Cuando aceptó a cristo: </b>{{ applicant.christ_accepted }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Fecha de bautismo: </b>{{ applicant.christening_date }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Es miembro desde: </b>{{ applicant.time_being_member }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Privilegios desempeñados: </b>{{ applicant.privileges_held }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Denominación: </b>{{ applicant.denomination }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Razón de estudio: </b>{{ applicant.study_reason }}</label>
                            </div>
                        </div>
                        <hr />
                        <h5 class="fs-4 fw-bold">Información Ministerial</h5>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Ministerio desempeñado: </b>{{ applicant.ministry_performed }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Ministerio actual: </b>{{ applicant.current_ministry }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Está a tiempo completo: </b>{{ applicant.full_time ? 'Si' : 'No' }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Calificación del ministerio: </b>{{ applicant.ministry_qualification }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Ministerio al que aspira: </b>{{ applicant.aspirated_ministry }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Razón para aspirar: </b>{{ applicant.reason_aspiring_ministry }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Ciclo que va a tomar: </b>{{ applicant.cicle_to_be_taken }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Institución en la que estudió: </b>{{ applicant.previous_institution }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Ultimo año en que estudió: </b>{{ applicant.last_year_studied }}</label>
                            </div>
                        </div>
                        <div class="formgrid grid row">
                            <div class="field col-6 w-100 mb-2">
                                <label><b>Cualidades de un obrero cristiano: </b>{{ applicant.qualities_religious_worker }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success d-flex justify-content-center fs-5">Inscribir <span class="material-icons ms-2 d-flex align-items-center">done</span></button>
                        <button type="button" class="btn btn-secondary d-flex justify-content-center fs-5">Rechazar <span class="material-icons ms-2 d-flex align-items-center">close</span></button>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h3 class="m-3">Registro de Estudiantes</h3>
            <h5 class="m-3 mb-4">Selecciona o busca el aplicante que vayas a inscribir</h5>
        </div>
        <div class="container-fluid">
            <DataTable title="Aplicantes disponibles" personalized :headers="[
                { title: 'Nombres', value: 'name' },
                { title: 'Apellidos', value: 'last_name' },
                { title: 'Telefono', value: 'phone' },
                { title: 'Correo', value: 'email' },
                { title: 'Dirección', value: 'address' },
                { title: 'Fecha de registro', value: 'registration_date' },
                { title: 'Acciones' }
            ]" :items="applicants">
                <template #actions="item">
                    <button type="button" @click.prevent="showApplicant(item)"
                        class="btn btn-primary d-flex justify-content-center" title="Ver información detallada"
                        data-bs-toggle="modal" data-bs-target="#applicantModal">
                        <span class="material-icons">account_box</span>
                    </button>
                </template>
            </DataTable>
        </div>
    </section>
</template>