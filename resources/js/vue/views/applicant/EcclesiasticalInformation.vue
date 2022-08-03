<script>
    export default{
    data() {
        return {
            
            ecclesiasticalInfo:{
                is_pastor: null,
                is_member: null,
                pastor_phone: '',
                church_name: '',
                church_address: '',
                church_phone: '',
                district: '',
                pastor_name: '',
                licence: '',
                reference_name_one: '',
                reference_phone_one: '',
                reference_name_two: '',
                reference_phone_two: '',
                christ_accepted: '',
                christening_date: '',
                time_being_member:'',
                privileges_held: '',
                denomination: '',
                study_reason: ''
            }

        }
    },
    setup() {
        document.title = 'IBBACH  | Formulario de inscripción'
    },
    methods: {
        passData() {
            const referenceObject = this.ecclesiasticalInfo
            referenceObject.pastor_phone = referenceObject.pastor_phone ? referenceObject.pastor_phone.replace('-', '') : ''
            referenceObject.church_phone = referenceObject.church_phone ? referenceObject.church_phone.replace('-', '') : ''
            referenceObject.reference_phone_one = referenceObject.reference_phone_one ? referenceObject.reference_phone_one.replace('-', '') : ''
            referenceObject.reference_phone_two = referenceObject.reference_phone_two ? referenceObject.reference_phone_two.replace('-', '') : ''
            this.$emit('ecclesiasticalInfo', this.ecclesiasticalInfo)
        },
        clearInputs() {
            this.ecclesiasticalInfo.is_pastor = null
            this.ecclesiasticalInfo.is_member = null
            this.ecclesiasticalInfo.pastor_phone = ''
            this.ecclesiasticalInfo.church_name = ''
            this.ecclesiasticalInfo.church_address = ''
            this.ecclesiasticalInfo.church_phone = ''
            this.ecclesiasticalInfo.district = ''
            this.ecclesiasticalInfo.pastor_name = ''
            this.ecclesiasticalInfo.licence = ''
            this.ecclesiasticalInfo.reference_name_one = ''
            this.ecclesiasticalInfo.reference_phone_one = ''
            this.ecclesiasticalInfo.reference_name_two = ''
            this.ecclesiasticalInfo.reference_phone_two = ''
            this.ecclesiasticalInfo.christ_accepted = ''
            this.ecclesiasticalInfo.christening_date = ''
            this.ecclesiasticalInfo.time_being_member = ''
            this.ecclesiasticalInfo.privileges_held = ''
            this.ecclesiasticalInfo.denomination = ''
            this.ecclesiasticalInfo.study_reason = ''
        }
    },
    expose: ['passData','clearInputs'],
    watch: {
        'ecclesiasticalInfo.pastor_phone'(value) {
            //let phoneNumber = value
            if (value.length === 8) {
                let cleaned = ('' + value).replace(/\D/g, '')
                let match = cleaned.match(/^(\d{4})(\d{4})$/)
                if (match) {
                    this.ecclesiasticalInfo.pastor_phone = match[1] + '-' + match[2]
                }
                else {
                    this.ecclesiasticalInfo.pastor_phone = ''
                }
            }
            if (value.length > 9) {
                this.ecclesiasticalInfo.pastor_phone = value.slice(0, -1)
            }
        },
        'ecclesiasticalInfo.church_phone'(value) {
            let phoneNumber = value
            if (phoneNumber.length === 8) {
                let cleaned = ('' + phoneNumber).replace(/\D/g, '')
                let match = cleaned.match(/^(\d{4})(\d{4})$/)
                if (match) {
                    this.ecclesiasticalInfo.church_phone = match[1] + '-' + match[2]
                }
                else {
                    this.ecclesiasticalInfo.church_phone = ''
                }
            }
            if (phoneNumber.length > 9) {
                this.ecclesiasticalInfo.church_phone = phoneNumber.slice(0, -1)
            }
        },
        'ecclesiasticalInfo.reference_phone_one'(value) {
            let phoneNumber = value
            if (phoneNumber.length === 8) {
                let cleaned = ('' + phoneNumber).replace(/\D/g, '')
                let match = cleaned.match(/^(\d{4})(\d{4})$/)
                if (match) {
                    this.ecclesiasticalInfo.reference_phone_one = match[1] + '-' + match[2]
                }
                else {
                    this.ecclesiasticalInfo.reference_phone_one = ''
                }
            }
            if (phoneNumber.length > 9) {
                this.ecclesiasticalInfo.reference_phone_one = phoneNumber.slice(0, -1)
            }
        },
        'ecclesiasticalInfo.reference_phone_two'(value) {
            let phoneNumber = value
            if (phoneNumber.length === 8) {
                let cleaned = ('' + phoneNumber).replace(/\D/g, '')
                let match = cleaned.match(/^(\d{4})(\d{4})$/)
                if (match) {
                    this.ecclesiasticalInfo.reference_phone_two = match[1] + '-' + match[2]
                }
                else {
                    this.ecclesiasticalInfo.reference_phone_two = ''
                }
            }
            if (phoneNumber.length > 9) {
                this.ecclesiasticalInfo.reference_phone_two = phoneNumber.slice(0, -1)
            }
        }
    }
    
}
</script>

<template>
    <section class="w-100 text-black">
        <h3 class="fw-bold text-center mb-5 section-title">Datos Eclesiásticos</h3>
        <div class="questions-container">
            <div class="mb-3">
                <label class="form-label">¿Es pastor?</label>
                <select class="form-select" v-model="ecclesiasticalInfo.is_pastor">
                    <option selected>-- --</option>
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>
                <label class="form-label">¿Es Miembro?</label>
                <select class="form-select" v-model="ecclesiasticalInfo.is_member">
                    <option selected>-- --</option>
                    <option value="1">Si</option>
                    <option value="0">No</option>   
                </select>
            </div>
            <div class="mb-3">
                <label for="churchName" class="form-label">¿De qué iglesia?</label>
                <input type="text" class="form-control" id="churchName" placeholder="Nombre" v-model="ecclesiasticalInfo.church_name" required>
            </div>
            <div class="mb-3">
                <label for="churchAddress" class="form-label">Dirección de la iglesia</label>
                <input type="text" class="form-control" id="churchAddress" placeholder=" municipio, departamento" v-model="ecclesiasticalInfo.church_address" required>
            </div>
            <div class="mb-3">
                <label for="phone2" class="form-label">Teléfono de la iglesia</label>
                <input type="text" class="form-control" id="phone2" placeholder="6458-5955" v-model="ecclesiasticalInfo.church_phone" required>
            </div>
            <div class="mb-3">
                <label for="district" class="form-label">Distrito</label>
                <input type="text" class="form-control" id="district" placeholder="Distrito" v-model="ecclesiasticalInfo.district" required>
            </div>
            <div class="mb-3" v-if="ecclesiasticalInfo.is_member === '1'">
                <label for="MemOrPas" class="form-label">Si es miembro escriba el nombre de su pastor</label>
                <input type="text" class="form-control" id="MemOrPas" placeholder="Nombre" v-model="ecclesiasticalInfo.pastor_name" required>
            </div>
            <div class="d-flex" v-if="ecclesiasticalInfo.is_member === '1'">
                <div>
                    <label for="licence" class="form-label">Licencia</label>
                    <input type="text" class="form-control" id="licence" placeholder="licencia" v-model="ecclesiasticalInfo.licence" required>
                </div>
                <div class="mb-3">
                    <label for="phone3" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="phone3" placeholder="6458-5955"
                        v-model="ecclesiasticalInfo.pastor_phone" required>
                </div>
            </div>
            <br />
            <div class="mb-2 mt-3">
                <label for="nationality" class="form-label">Anote el nombre y teléfono de dos pastores de Las Asambleas
                    de Dios que puedan dar referencias suyas</label>
            </div>
            <div class="d-flex">
                <div>
                    <label for="pastor1" class="form-label">Nombre del Pastor</label>
                    <input type="text" class="form-control" id="pastor1" placeholder="Nombre" v-model="ecclesiasticalInfo.reference_name_one" required>
                </div>
                <div class="mb-3">
                    <label for="phone4" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="phone4" placeholder="6458-5955"
                        v-model="ecclesiasticalInfo.reference_phone_one" required>
                </div>
            </div>
            <div class="d-flex">
                <div class="mb-3">
                    <label for="pastor2" class="form-label">Nombre del Pastor</label>
                    <input type="text" class="form-control" id="pastor2" placeholder="Nombre" v-model="ecclesiasticalInfo.reference_name_two" required>
                </div>
                <div class="mb-3">
                    <label for="phone5" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="phone5" placeholder="6458-5955"
                        v-model="ecclesiasticalInfo.reference_phone_two" required>
                </div>
            </div>
            <br />
            <div class="mb-3">
                <label for="lgsus" class="form-label">¿Cuando aceptó a Jesucristo?</label>
                <textarea class="form-control" id="lgsus" placeholder="Aproximado" v-model="ecclesiasticalInfo.christ_accepted" required></textarea>
            </div>
            <div class="mb-3">
                <label for="christeningDate" class="form-label">¿Cuando se bautizó?</label>
                <input type="date" class="form-control" id="christeningDate" v-model="ecclesiasticalInfo.christening_date" required>
            </div>
            <div class="mb-3">
                <label for="timeBeingMember" class="form-label">¿Cuanto tiempo tiene de ser miembro de su
                    iglesia?</label>
                <input type="text" class="form-control" id="timeBeingMember" placeholder="Aproximado" v-model="ecclesiasticalInfo.time_being_member" required>
            </div>
            <div class="mb-3">
                <label for="privilegesHeld" class="form-label">¿Cuales son los privilegios en que se ha
                    desempeñado?</label>
                <textarea type="text" class="form-control" id="privilegesHeld" placeholder="Aproximado" v-model="ecclesiasticalInfo.privileges_held" required></textarea>
            </div>
            <div class="mb-3">
                <label for="denomination" class="form-label">¿A qué denominación pertenece?</label>
                <input type="text" class="form-control" id="denomination" placeholder="Aproximado" v-model="ecclesiasticalInfo.denomination" required>
            </div>
            <div class="mb-3">
                <label for="studyReason" class="form-label">¿Cuál es el interés de estudiar en el Instituto Bíblico
                    Betel Anexo? </label>
                <textarea type="text" class="form-control" id="studyReason" placeholder="Aproximado" v-model="ecclesiasticalInfo.study_reason" required></textarea>
            </div>
        </div>
    </section>
</template>
<style scoped>
.form-title {
    text-shadow: 2px 2px 3px rgb(0, 0, 0);
}

.form-container {
    background: var(--bs-gray-400);
    border: 6px solid #ccc;
}

.section-title {
    text-decoration: underline;
}

.questions-container {
    display: grid;
    justify-content: left;
}
</style>