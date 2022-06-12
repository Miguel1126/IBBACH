<script>
export default{
    data() {
        return {
        codes: [
            {id: 1, code:'al1126'},
            { id: 2, code: 'do1127' },
            { id: 3, code: 'se1128' },
            { id: 4, code: 'ad1129' }
            ],
        passwords: [
            {id: 1, password:'1126al'},
            { id: 2, password: '1127do' },
            { id: 3, password: '1128se' },
            { id: 4, password: '1129ad' }
            ],
        utypes: [
            {id: 1, utype:'Alumno'},
            { id: 2, utype: 'Docente' },
            { id: 3, utype: 'Secretaria' },
            { id: 4, utype: 'Administrador' }
            ],
        aplicants: [
            {id: 1, aplicant:'Stan Smith'},
            { id: 2, aplicant: 'Bender Rodriguez' },
            { id: 3, aplicant: 'Homero Simpson' },
            { id: 4, aplicant: 'Rick Sanchez ' }
            ],
        users: [
            {id: 1, code:'al1126', password:'1126al', utype:'Alumno', aplicant:'Stan Smith'},
            { id: 2, code: 'do1127', password: '1127do',  utype: 'Docente',  aplicant: 'Bender Rodriguez'},
            { id: 3, code: 'se1128', password: '1128se', utype: 'Secretaria',  aplicant: 'Homero Simpson'},
            { id: 4, code: 'ad1129',  password: '1129ad',  utype: 'Administrador',  aplicant: 'Rick Sanchez'}
        ],
            code: null,
            password: null,
            editing: false,
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
                <input type="text" v-model="code" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Codigo de usuario">
            </div>
            <br />
              <div class="input-group input-group-lg w-25">
                <span class="input-group-text" id="inputGroup-sizing-lg"><i class="material-icons">key</i></span>
                    <input type="text" v-model="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Contraseña">
            </div>
            <br />
            <div class="d-flex">
            <div class="dropdown m-4">
            <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                <span class=" p- "><i class="material-icons">account_circle</i></span>
                <span v-if="!utySelected.length">Tipo de usuario</span>
                <span v-else>{{ utySelected[0] }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                <li v-for="utype in utypes" :key="utype.id" class="dropdown-item"><button class="text-light" @click="SelectedUty($event, utype.utype)">{{ utype.utype }}</button></li> 
            </ul>
            </div>
            <div class="dropdown m-4">
            <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                <span class=" p-1 "><i class="material-icons">person</i></span>
                <span v-if="!apliSelected.length">Aplicante</span>
                <span v-else>{{ apliSelected[0] }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                <li v-for="aplicant in aplicants" :key="aplicant.id" class="dropdown-item"><button class="text-light" @click="SelectedApli($event, aplicant.aplicant)">{{ aplicant.aplicant }}</button></li> 
            </ul>
            </div>
            </div>
        </section>
        <section class=" p-3 ">
            <h3 class="h3 fw-semibold mb-3">Listado de usuarios</h3>
            <table class="table table-bordered border-white">
                <thead class="table-bordered border-white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Contraseña</th>
                        <th scope="col">Tipo de usuario</th>
                        <th scope="col">Aplicante</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider border-white">
                    <tr v-for="user in users" :key="user.id">
                        <th scope="row">{{ user.id }}</th>
                        <td>{{ user.code }}</td>
                        <td>{{ user.password }}</td>
                        <td>{{ user.utype }}</td>
                        <td>{{ user.aplicant }}</td>
                        <td class="d-flex justify-content-center"><button type="button" class="btn btn-primary me-2">Modificar</button><button type="button" class="btn btn-danger">Eliminar</button></td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
</template>
<style>
   .load {
        border-radius: 15px !important;
    }
    tr, td{
        color: white;
    }
</style>