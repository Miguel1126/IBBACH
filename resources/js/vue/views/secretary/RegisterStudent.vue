<script>
import DataTable from '../../components/DataTable.vue';
import UserInfoCard from '../../components/UserInfoCard.vue';
import { formatDate } from '../../js/format_time';
import { handleErrors } from '../../js/handle_error';

export default {
    mounted() {
        document.title = 'IBBACH | Registro de estudiantes'
        this.getApplicants(1, true)
        this.getGroups()
    },
    data() {
        return {
            applicants: [],
            groups: [],
            applicant: {},
            paginationLinks: [],
            loading: false,
            success: false,
            registering: false,
            picked: '',
            user: {},
            siteUrl: window.location.origin
        }
    },
    methods: {
        async getApplicants(pageNumber, firstLoad = false) {
            if (firstLoad) this.applicants[0] = 'loading'

            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }

            try {
                const response = await this.axios.get('/api/aplicantes-pendientes?page=' + pageNumber)
                if (response.status === 200) {

                    this.applicants = this.formateDate(response.data.data)
                    this.paginationLinks = response.data.links
                }
                else {
                    this.applicants[0] = 'error'
                }
            }
            catch (error) {
                handleErrors(error)
                this.applicants[0] = 'error'
            }
        },
        async getGroups() {
            try {
                const response = await this.axios.get('/api/get-grupos')
                this.groups = response.data
            }
            catch (error) {
                handleErrors(error)
            }
        },
        showApplicant(applicant) {
            this.applicant = {}
            this.applicant = applicant.item
        },
        async registerStudent(applicantId) {
            if (this.picked) {
                this.loading = true
                this.success = false
                try {
                    const response = await this.axios.post('/api/inscribir', { applicant_id: applicantId, groupId: this.picked })
                    if (response.status === 201) {
                        this.user = { ...response.data }
                        this.success = true
                        this.registering = false
                        this.picked = ''
                        this.getApplicants()
                        document.getElementById('close-modal').click()
                    }
                    else {
                        this.$swal.fire("Error", "Ocurrió un error, inténtalo de nuevo", "error")
                    }
                }
                catch (error) {
                    handleErrors(error)
                    this.$swal.fire("Error", "Ocurrió un error, inténtalo de nuevo", "error")
                }
            }
            else {
                this.registering = true
            }
            this.loading = false
        },
        denyApplicant({ applicant }) {
            this.loading = true
        
            const payload = {
                personalInfoId: applicant.personal_information_id, 
                ecclesiasticalInfoId: applicant.ecclesiastical_information_id,
                ministerialInfoId: applicant.ministerial_information_id,
                applicantId: applicant.id,
                imgName: applicant.img
            }

            this.$swal.fire({
                title: '¿Estás seguro de rechazar este aplicante?',
                text: "La acción no se podrá revertir",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, rechazar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.axios.delete('/api/rechazar', {data: {...payload}})
                        .then(response => {
                            if (response.status === 200) {
                                this.getApplicants()
                                this.$swal.fire(
                                    '¡Listo!',
                                    'El aplicante ha sido rechazado',
                                    'success'
                                )
                                document.getElementById('close-modal').click()
                            }
                            else {
                                this.$swal.fire("Error", "No se pudo rechazar el aplicante, inténtalo de nuevo", "error")
                            }
                        })
                        .catch(error => {
                            handleErrors(error)
                            this.$swal.fire("Error", "Ocurrió un error, inténtalo de nuevo", "error")
                        })
                }
            })

            this.loading = false
        },
        /**
         * 
         * @param {Array} data 
         */
        formateDate(data) {
            data.forEach(m => m.created_at = formatDate(m.created_at))
            return data
        },

    },
    components: { DataTable, UserInfoCard },
}
</script>
<template>
    <section>
        <div class="modal fade text-black text-opacity-75" id="applicantModal" tabindex="-1"
            aria-labelledby="applicantModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-3" id="staticBackdropLabel">Detalle del aplicante</h5>
                        <button type="button" id="close-modal"
                            class="btn btn-danger text-light d-flex justify-content-center" data-bs-dismiss="modal"
                            aria-label="Close" @click.prevent="registering = false"><span
                                class="material-icons">close</span></button>
                    </div>
                    <div class="modal-body">
                        <div :class="registering ? 'd-none' : ''">
                            <h5 class="fs-4 fw-bold">Información Personal</h5>
                            <div class="field w-100 mb-2">
                                <img style="width: 200px; height: 200px" class="img-fluid"
                                    :src="`${siteUrl}/images/users/${applicant.img}`" />
                            </div>
                            <div class="field w-100 mb-2">
                                <label><b>Nombre completo: </b>{{ applicant.name }} {{ applicant.last_name }}</label>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Fecha en que aplicó: </b>{{ applicant.created_at }}</label>
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
                                    <label class="ms-2"><b>Teléfono: </b>{{ applicant.reference_phone_one }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Pastor de referencia 2: </b>{{ applicant.reference_name_two }}</label>
                                    <label class="ms-2"><b>Teléfono: </b>{{ applicant.reference_phone_two }}</label>
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
                                    <label><b>Está a tiempo completo: </b>{{ applicant.full_time ? 'Si' : 'No'
                                    }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Calificación del ministerio: </b>{{ applicant.ministry_qualification
                                    }}</label>
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
                                    <label><b>Institución en la que estudió: </b>{{ applicant.previous_institution
                                    }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Ultimo año en que estudió: </b>{{ applicant.last_year_studied }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Cualidades de un obrero cristiano: </b>{{
                                    applicant.qualities_religious_worker
                                    }}</label>
                                </div>
                            </div>
                        </div>
                        <div :class="registering ? 'd-block' : 'd-none'">
                            <p><b>Selecciona la modalidad para: {{ applicant.name }} {{ applicant.last_name }}</b></p>
                            <div v-for="group in groups" class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" :name="groups.group" :id="group.group"
                                    :value="group.id" v-model="picked">
                                <label class="form-check-label cursor-pointer" :for="group.group">{{ group.group
                                }}</label>
                            </div>
                            <button type="button" class="btn btn-danger d-flex justify-content-center mt-4"
                                @click.prevent="registering = false; picked = ''">Cancelar
                                <span class="material-icons ms-2 d-flex align-items-center">close</span></button>
                        </div>
                    </div>
                    <div class="modal-footer" v-if="!loading">
                        <button type="button" class="btn btn-success d-flex justify-content-center fs-5"
                            @click.prevent="registerStudent(applicant.id)">
                            <span>Registrar</span>
                            <span class="material-icons ms-2 d-flex align-items-center">done</span></button>
                        <button type="button" class="btn btn-secondary d-flex justify-content-center fs-5"
                            @click.prevent="denyApplicant({applicant})">Rechazar
                            <span class="material-icons ms-2 d-flex align-items-center">close</span></button>
                    </div>
                    <span class="d-flex justify-content-end ms-1 mb-4 px-5" v-else>
                        <div class="mt-3 dot-pulse">
                            <div class="dot-pulse__dot"></div>
                        </div>
                    </span>
                </div>
            </div>
        </div>

        <div>
            <h3 class="m-3">Selecciona el aplicante que vayas a registrar</h3>
        </div>
        <div class="container-fluid">
            <DataTable title="Aplicantes disponibles" personalized :headers="[
                { title: 'Nombres', value: 'name' },
                { title: 'Apellidos', value: 'last_name' },
                { title: 'Telefono', value: 'phone' },
                { title: 'Correo', value: 'email' },
                { title: 'Dirección', value: 'address' },
                { title: 'Fecha de registro', value: 'created_at' },
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
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks" :key="page">
                        <span class="page-link" @click="getApplicants(page.url)">{{ page.label == 'pagination.previous'
                        ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
            </nav>
            <UserInfoCard :userinfo="user" v-if="success"></UserInfoCard>
        </div>
    </section>
</template>
<style scoped>
.cursor-pointer {
    cursor: pointer;
}

.dot-pulse {
    --uib-size: 40px;
    --uib-speed: 1.3s;
    --uib-color: rgb(39, 39, 39);

    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: var(--uib-size);
    height: calc(var(--uib-size) * 0.27);
}

.dot-pulse__dot,
.dot-pulse::before,
.dot-pulse::after {
    content: '';
    display: block;
    height: calc(var(--uib-size) * 0.18);
    width: calc(var(--uib-size) * 0.18);
    border-radius: 50%;
    background-color: var(--uib-color);
    transform: scale(0);
}

.dot-pulse::before {
    animation: pulse var(--uib-speed) ease-in-out infinite;
}

.dot-pulse__dot {
    animation: pulse var(--uib-speed) ease-in-out calc(var(--uib-speed) * 0.125) infinite both;
}

.dot-pulse::after {
    animation: pulse var(--uib-speed) ease-in-out calc(var(--uib-speed) * 0.25) infinite;
}

@keyframes pulse {

    0%,
    100% {
        transform: scale(0);
    }

    50% {
        transform: scale(1.5);
    }
}
</style>