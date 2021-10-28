<template>
  <q-page class="flex flex-center">
    <q-card id="loginForm">
      <q-card-section class="row">
        <div class="text-h6">Login</div>
      </q-card-section>
      <form @submit.prevent="login">
        <q-card-section>
          <q-input
            Filled
            type="email"
            v-model="usuario.email"
            :rules="[(val) => !!val || 'Esse campo é obrigatorio']"
            label="Email"
            class="col"
          >
            <template v-slot:prepend>
              <q-icon name="mail" />
            </template>
          </q-input>
          <q-input
            Filled
            v-model="usuario.password"
            :type="isPwd ? 'Password' : 'text'"
            :rules="[(val) => !!val || 'Esse campo é obrigatorio']"
            label="Senha"
            class="col q-mt-md"
          >
            <template v-slot:prepend>
              <q-icon name="lock" />
            </template>

            <template v-slot:append>
              <q-icon
                :name="isPwd ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="isPwd = !isPwd"
              />
            </template>
          </q-input>
        </q-card-section>
        <q-card-actions align="center">
          <q-btn 
          flat 
          type="submit" 
          color="white" class="bg-primary"
            >Entrar</q-btn
          >
        </q-card-actions>
      </form>
    </q-card>
  </q-page>
</template>

<script>
import { defineComponent, onMounted } from "vue";
import { api } from 'boot/axios';
import { mapGetters, mapActions } from 'vuex';

export default defineComponent({
  name: "Login",
  data() {
    return {
      usuario:{
        email: "",
        password: ""
      },
      isPwd: true
    };
  },
  methods: {
    login () {
      const app = this

      const formData = new FormData()
      formData.append('email', this.usuario.email)
      formData.append('password', this.usuario.password)

      app.$q.loading.show()
      api.post('/api/auth/login', formData)
        .then(function (response) {
          if (response.data.is_loged === true) {
            localStorage.setItem('token', response.data.token)
            app.$axios.defaults.headers.common.Authorization = 'Bearer' + ' ' + response.data.token

            app.$store.commit('JwtLaravel/setUserData', response.data.user)

            app.$router.push('/perfil')
          } else {
            app.showNotif('Falha na autenticacao.')
          }
        })
        .finally(function () {
          app.$q.loading.hide()
        })
    },

    showNotif (message, icon = 'error', color = 'red') {
      this.$q.notify({
        message: message,
        icon: icon,
        color: color,
        position: 'bottom-right',
        progress: true
      })
    }
   
    // login(){
    //   const app = this
    //   const formData = new FormData()
    //   formData.append('email', this.usuario.email);
    //   formData.append('password', this.usuario.password);

    //   app.$q.loading.show()
    //   this.$axios.post
    //   // try {
    //   //   api.post('/api/auth/login', this.usuario, {
    //   //     headers : {
    //   //       'Content-Type' : 'application/json'
    //   //     },
    //   //     Credential: 'include'
    //   //   }).then(Response => {
    //   //     console.log(Response)
    //   //   }).catch((error) => {
    //   //     console.log(error)
    //   //   })
    //   //   this.updateAuth(true)
    //   // } catch (error) {
    //   //   console.log(error)
    //   // }
    // }
  },
  setup(){
    api.get('/sanctum/csrf-cookie').then(Response => {
      console.log(Response)
    })
  },
});
</script>

<style>
#loginForm {
  width: 500px;
}
</style>
