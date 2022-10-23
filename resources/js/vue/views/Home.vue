<script>







export default {
	mounted() {
		this.getPublications()

	},
	data() {
		return {
			siteUrl: window.location.origin,
			publications: [],

		}
	},
	components: {

	},
	setup() {
		document.title = "IBBACH | Home"

	},
	methods: {
		async getPublications() {
			try {
				const response = await this.axios.get('/api/getpublications')
				if (response.status === 200) {

					this.publications = response.data.data;

				}
				else {
					this.publications[0] = 'error'
				}
			}
			catch (error) {
				handleErrors(error)
				this.publications[0] = 'error'
			}
		},

	},
}
</script>
<template>
	<nav class="navbar navbar-expand-lg ">
  <div class="container-fluid">
    <a class="navbar-brand" href="http://127.0.0.1:8000/"><img class=" img-fluid logo-image" :src="`${siteUrl}/images/logo.jpg`" /></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item m-1">
			<router-link class="links link" to="/login">Iniciar Sesión</router-link>
        </li>
        <li class="nav-item m-1">
			<router-link class="links link" to="/aplicante/formulario">Solicitud de Ingreso</router-link>
        </li>
        <li class="nav-item m-1">
			<router-Link class="links link" to="/ProgramaEstudio">Programa de estudio</router-Link>
        </li>
      </ul>
    </div>
  </div>
</nav>
	<div class="container">
		<h1 class="text-center my-4">Instituto Bíblico Betel Anexo Chalatenango</h1>
	</div>
	<div id="demo" class="carousel slide m-4" data-bs-ride="carousel"  >
		<div class="carousel-inner">
			<div v-for="publication in publications" class="carousel-item active"   >
				<img :src="`${siteUrl}/images/publications/${publication.img}`" class="img mx-auto img-fluid  d-block" style=" min-width: 200px; min-height: 300px; max-width: 250px; max-height: 350px;"/>
			</div>
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
			<span class="carousel-control-prev-icon"></span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
			<span class="carousel-control-next-icon"></span>
		</button>
	</div>
	<div class="row m-3">
		<div class="col-sm-6">
			<div class="card text-white mb-3" style="background-color: #0643A4;">
				<div class="card-body">
					<h5 class="card-title">MISIÓN
					</h5>
					<p class="card-text">Enriquecer las capacidades espirituales e intelectuales de los llamados por el
						Señor
						Jesucristo a ser ministros del evangelio en la predicación, enseñanza, evangelismo,
						discipulado y administración eclesiástica; transmitiendo el carácter de Cristo por el
						ejemplo.</p>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="card text-white mb-3" style="background-color: #0643A4;">
				<div class="card-body">
					<h5 class="card-title">VISIÓN
					</h5>
					<p class="card-text">Formar ministros llenos del Espíritu Santo y del conocimiento de la Palabra de
						Dios
						para que sean pastores, maestros y líderes útiles para El Salvador y el mundo.</p>
					<br>
				</div>
			</div>
		</div>
	</div>
	<footer class="section footer-classic context-dark bg-image" style=" background: #272525;">
		<div class="container-fluid">
			<div class="row row-30">
				<div class="col-md-4 col-xl-5">
					<div class="pr-xl-4"><a class="brand" href="http://127.0.0.1:8000/"><img
								class=" d-block img-fluid rounded mt-3" style="width: 20%; height: 20%;"
								:src="`${siteUrl}/images/logo.jpg`" /></a>
						<br>
						<h6> El Instituto Bíblico Betel Anexo Chalatenango, inició operaciones en 1996 y se dedica a la
							formación de ministros para las diferentes áreas que el ministerio cristiano exige,
							pastores, evangelistas y misioneros. Una institución para formar a hombres y mujeres para la
							obra del ministerio</h6>
					</div>
				</div>
				<div class="col-md-4">
					<dl class="contact-list d-block">
						<div class="d-inline-flex gap-1 align-items-center">
							<h5>Contactos</h5>
						</div>
					</dl>
					<dl class="contact-list d-block">
						<div class="d-inline-flex gap-1 align-items-center">
							<div>
								<h6>Direccion: </h6>
								<p>
									<a target="_blank" href="https://goo.gl/maps/UhWRrTBXpxHZsVha7">Potrero Grande a
										Iglesia Filipos de las
										Asambleas de Dios por Carr. longitudinal del Nte./CA-3</a>
								</p>
							</div>
						</div>
						<br>
						<div class="d-inline-flex gap-1 align-items-center">
							<div>
								<h6>Correo Electronico: </h6>
								<p>ibbachal@yahoo.com</p>
							</div>
						</div>
						<br>
						<div class="d-inline-flex gap-1 align-items-center">
							<div>
								<h6>Telefono: </h6>
								<p>2309 2234</p>
							</div>
						</div>
					</dl>
				</div>
				<div class="col-md-4 col-xl-3">
					<h5>Redes sociales</h5>
					<ul class="navbar-nav">
						<div class="d-inline-flex gap-1 align-items-center">
							<div>
								<p>
									<a target="_blank" href="https://www.facebook.com/ibbachad">
										<i class="text-primary fa-brands fa-square-facebook"
											style="font-size: 50px"></i></a>
								</p>
							</div>
						</div>
						<p>
							<a target="_blank" href="https://wa.me/+50369840681">
								<i class="text-success fa-brands fa-square-whatsapp" style="font-size: 50px"></i></a>
						<h6>6984-0681</h6>
						<a target="_blank" href="https://wa.me/+50370527126">
							<i class="text-success fa-brands fa-square-whatsapp" style="font-size: 50px"></i></a>
						<h6>7052-7126</h6>
						</p>
					</ul>
				</div>
			</div>
			<p class="rights text-center"><span>©  </span><span
					class="copyright-year">2022</span><span> </span><span>IBBACH</span><span>. </span><span></span>
			</p>
		</div>
	</footer>
</template> 
<style scoped>
.navbar {
	display: flex;
	justify-content: space-between;
	background-color: var(--dark-alt);
}

.links{
	color: #eee;
	text-decoration: none;
	font-style: 1.5em;
	
}
.link:hover{
	background-color: var(--dark);
	padding: 5px;
	border-radius: 13px;
}
.logo-image {
	width: 50px;
	height: 50px;
	margin-left: 9px;
	border-radius: 3px;
}

.tabs div {
	background-color: var(--dark);
}

.focused {
	background-color: var(--dark-alt) !important;
}

.component-container {
	background-color: var(--dark-alt);
}






.section {
	position: absolute;
	width: 100%;
	height: 90;
}


</style>

