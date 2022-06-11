<script>
export default{
    data() {
        return {
            utypes: [
            {id:1, utype:'Alumno'},
            { id: 2, utype: 'Docente' },
            { id: 3, utype: 'Secretaria' },
            { id: 4, utype: 'Administrador' }
            ],
        aplicants: [
            {id:1, aplicant:'Alumno'},
            { id: 2, aplicant: 'Docente' },
            { id: 3, aplicant: 'Secretaria' },
            { id: 4, aplicant: 'Administrador' }
            ],
            utySelected: [],
            apliSelected: []
        }
    },
    methods: {
        SelectedUty(event, utype) {
                this.utySelected = []
                this.utySelected.push(utype)
            },
            SelectedApli(event, aplicant) {
                this.apliSelected = []
                this.apliSelected.push(aplicant)
            },
    }

}
</script>

<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">Registro de usuarios</h1>
         <br />
        <section>
            <h3 class="h3 fw-semibold">Registrar un nuevo usuario</h3>
            <div class="input-group input-group-lg w-25">
                <span class="input-group-text" id="inputGroup-sizing-lg"><i class="material-icons">label</i></span>
                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Codigo de usuario">
            </div>
            <br />
              <div class="input-group input-group-lg w-25">
                <span class="input-group-text" id="inputGroup-sizing-lg"><i class="material-icons">key</i></span>
                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Contraseña">
            </div>
            <br />
            <div class="d-flex">
            <div class="dropdown m-4">
            <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                <span class=" p-2 "><i class="material-icons">account_circle</i></span>
                <span v-if="!utySelected.length">Tipo de usuario</span>
                <span v-else>{{ utySelected[0] }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                <li v-for="utype in utypes" :key="utype.id" class="dropdown-item"><button class="text-light" @click="SelectedUty($event, utype.utype)">{{ utype.utype }}</button></li> 
            </ul>
            </div>
            <div class="dropdown m-4">
            <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                <span class=" p-2 "><i class="material-icons">person</i></span>
                <span v-if="!apliSelected.length">Aplicante</span>
                <span v-else>{{ apliSelected[0] }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                <li v-for="aplicant in aplicants" :key="aplicant.id" class="dropdown-item"><button class="text-light" @click="SelectedApli($event, aplicant.aplicant)">{{ aplicant.aplicant }}</button></li> 
            </ul>
            </div>
            </div>
        </section>
    </main>
</template>