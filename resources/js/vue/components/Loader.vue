<script setup>
    defineProps({
        loading: {
            type: Boolean,
            default: true
        },
        error: {
            type: Boolean,
            default: false
        }
    })
    
    const reloadPage = () => {
        window.location.reload()
    }
</script>
<template>
  <div class="loading">
      <span v-if="loading" class="loader mb-5 me-4"></span>
      <div v-if="error" class="text-center">
          <h3 class="text-muted">Algo salió mal... :(</h3>
          <h5 class="text-muted mb-3">Revisa tu conexión.</h5>
          <button type="button" class="btn btn-light rounded-pill d-flex m-auto" @click="reloadPage()">Recargar <span class="material-symbols-outlined">replay</span></button>
      </div>
  </div>
</template>

<style scoped>
.loading {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    width: 100%;
    height: 100%;
    background: var(--dark-background);
    z-index: 99999;
    top: 0;
    left: 0;
    overflow: hidden;
}

.loader, .loader:before, .loader:after {
  border-radius: 50%;
  width: 2.5em;
  height: 2.5em;
  animation-fill-mode: both;
  animation: bblFadInOut 1.5s infinite ease-in-out;
}
.loader {
  color: #FFF;
  font-size: 7px;
  position: relative;
  text-indent: -9999em;
  transform: translateZ(0);
  animation-delay: -0.16s;
}
.loader:before,
.loader:after {
  content: '';
  position: absolute;
  top: 0;
}
.loader:before {
  left: -3.5em;
  animation-delay: -0.32s;
}
.loader:after {
  left: 3.5em;
}

@keyframes bblFadInOut {
  0%, 80%, 100% { box-shadow: 0 2.5em 0 -1.3em }
  40% { box-shadow: 0 2.5em 0 0 }
}
    
</style>