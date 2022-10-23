<script setup>
import Sidebar from './Sidebar.vue';
import Loader from '../../../components/Loader.vue';
import { handleToken } from '../../../js/handle_token'
import { ref } from '@vue/reactivity';
import { onMounted } from '@vue/runtime-core';
import axios from 'axios';
import { useUserStore } from '../../../stores/user';
import { router } from '../../../router';

const loading = ref(true)
const error = ref(false)

new Promise(resolve => {
	resolve(handleToken("admin"))
}).then(response => {
	if (response === "error") {
		loading.value = false
		error.value = true
	}
	if (response.status === "authenticated") {
		loading.value = false
		error.value = false
		axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.token
	}
})

document.title = "IBBACH | Admin"

</script>

<template>
	<Transition name="fade">
		<Loader v-if="loading || error" :loading="loading" :error="error"></Loader>
  	</Transition>
	<Sidebar></Sidebar>
	<router-view />
</template>