import Vue from 'vue'
import App from './App.vue'
import router from './router/index'

import '@babel/polyfill'
import './assets/main.scss'
import './plugins/bootstrap-vue'
import 'bulma/css/bulma.css'
import 'mutationobserver-shim'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

Vue.config.productionTip = false

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')