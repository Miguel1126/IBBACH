<script>
    export default{
    data() {
        return {
            
            ecclesiasticalInfo:{
                is_pastor: '',
                is_member: '',
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
    methods: {
        passData() {
            this.$emit('ecclesiasticalInfo', this.ecclesiasticalInfo)
        },
        formatPhone(id) {
        let phoneNumber = document.getElementById(id).value
        if (phoneNumber.length === 8) {
            let cleaned = ('' + phoneNumber).replace(/\D/g, '')
            let match = cleaned.match(/^(\d{4})(\d{4})$/)
            if (match) {
                document.querySelector(`#${id}`).value = match[1] + '-' + match[2]
            }
            else {
                document.querySelector(`#${id}`).value = ""
            }
            }
        if (phoneNumber.length > 9) {
            document.querySelector(`#${id}`).value = phoneNumber.slice(0, -1)
            }
        }
    }
    
}
</script>

<template>
    <div class="container-fluid d-block">
    <div class="m-auto">
        <h2 class="text-center m-4 form-title">Formulario de inscripción</h2>
        <h4 class="text-center m-3">Ingresa tus datos a continación, revisa muy bien la información antes de enviarla.</h4>
    </div>
    <div class="m-5 rounded form-container">
        <form class="d-block p-5" action="">
            <section class="w-100 text-black">
                     <h3 class="fw-bold text-center mb-5 section-title">Datos Eclesiásticos</h3>
                        <div class="questions-container">
                         <div class="mb-3">
                            <label class="form-label">¿Es pastor o miembro?</label>
                            <select class="form-select">
                                <option selected>-- --</option>
                                <option value="1">Pastor</option>
                                <option value="2">Miembro</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="churchName" class="form-label">¿De qué iglesia?</label>
                            <input type="text" class="form-control" id="churchName" placeholder="Nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="churchAddress" class="form-label">Dirección de la iglesia</label>
                            <input type="text" class="form-control" id="churchAddress" placeholder=" municipio, departamento" required>
                        </div>
                      <div class="mb-3">
                            <label for="phone2" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="phone2" placeholder="6458-5955" @input="formatPhone('phone2')" required>
                        </div>
                        <div class="mb-3">
                            <label for="district" class="form-label">Distrito</label>
                            <input type="text" class="form-control" id="district" placeholder="Distrito" required>
                        </div>
                        <div class="mb-3">
                            <label for="MemOrPas" class="form-label">Si es miembro escriba el nombre de su pastor</label>
                            <input type="text" class="form-control" id="MemOrPas" placeholder="Nombre" required>
                        </div>
                        <div class="d-flex">
                            <div>
                                <label for="licence" class="form-label">Licencia</label>
                                <input type="text" class="form-control" id="licence" placeholder="licencia" required>
                            </div>
                        <div class="mb-3">
                            <label for="phone3" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="phone3" placeholder="6458-5955" @input="formatPhone('phone3')" required>
                        </div>
                        </div>
                        <br/>
                            <div class="mb-3">
                                <label for="nationality" class="form-label">Anote el nombre y teléfono de dos pastores de Las Asambleas de Dios que puedan dar referencias suyas</label>
                            </div>
                            <div class="d-flex">
                                <div>
                                    <label for="pastor1" class="form-label">Nombre del Pastor</label>
                                    <input type="text" class="form-control" id="pastor1" placeholder="Nombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone4" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="phone4" placeholder="6458-5955" @input="formatPhone('phone4')" required>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="mb-3">
                                    <label for="pastor2" class="form-label">Nombre del Pastor</label>
                                    <input type="text" class="form-control" id="pastor2" placeholder="Nombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone5" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="phone5" placeholder="6458-5955" @input="formatPhone('phone5')" required>
                                </div>
                            </div>
                            <br/>
                            <div class="mb-3">
                                <label for="lgsus" class="form-label">¿Cuando aceptó a Jesucristo?</label>
                                <input type="text" class="form-control" id="lgsus" placeholder="Aproximado" required>
                            </div>
                        <div class="mb-3">
                            <label for="christeningDate" class="form-label">¿Cuando se bautizó?</label>
                            <input type="date" class="form-control" id="christeningDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="timeBeingMember" class="form-label">¿Cuanto tiempo tiene de ser miembro de su iglesia?</label>
                            <input type="text" class="form-control" id="timeBeingMember" placeholder="Aproximado" required>
                        </div>
                        <div class="mb-3">
                            <label for="privilegesHeld" class="form-label">¿Cuales son los privilegios en que se ha desempeñado?</label>
                            <input type="text" class="form-control" id="privilegesHeld" placeholder="Aproximado" required>
                        </div>
                        <div class="mb-3">
                            <label for="denomination" class="form-label">¿A qué denominación pertenece?</label>
                            <input type="text" class="form-control" id="denomination" placeholder="Aproximado" required>
                        </div>
                        <div class="mb-3">
                            <label for="studyReason" class="form-label">¿Cuál es el interés de estudiar en el Instituto Bíblico Betel Anexo? </label>
                            <input type="text" class="form-control" id="studyReason" placeholder="Aproximado" required>
                        </div>
                      </div>
            </section>
         </form>
    </div>
</div>
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