<template>
  <q-page class="flex flex-center">
    <q-card id="formRegisto">
      <q-card-section class="row">
        <div class="text-h6">Registo</div>
      </q-card-section>
      <form @submit.prevent="registar">
        <q-card-section>
          <q-input
            Filled
            type="text"
            v-model="usuario.nome"
            :rules="[(val) => !!val || 'Esse campo é obrigatorio']"
            label="Nome"
            class="col"
          >
            <template v-slot:prepend>
              <q-icon name="person" />
            </template>
          </q-input>
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
            type="password"
            v-model="usuario.password"
            :rules="[(val) => !!val || 'Esse campo é obrigatorio']"
            label="Senha"
            class="col q-mt-md"
          >
            <template v-slot:prepend>
              <q-icon name="lock" />
            </template>
          </q-input>
          <q-input
            Filled
            type="password"
            v-model="usuario.cpassword"
            :rules="[(val) => !!val || 'Esse campo é obrigatorio']"
            label="Confirmar senha"
            class="col q-mt-md"
          >
            <template v-slot:prepend>
              <q-icon name="lock" />
            </template>
          </q-input>
        </q-card-section>
        <q-card-actions align="center">
          <q-btn flat type="submit" color="white" class="bg-primary"
            >Registar</q-btn
          >
        </q-card-actions>
      </form>
    </q-card>
  </q-page>
</template>

<script>
import { api } from 'boot/axios';

export default {
  name: "Registar",
  data(){
    return {
      usuario : {
        nome: "",
        email: "",
        password: "",
        cpassword: ""
      }
    }
  },
  methods: {
    registar(){
      const app = this

      app.$q.loading.show()
      api.post('/api/usuario', this.usuario
      , {
        Headers: {
          'Content-Type' : 'application/json'
        }
      }).then(Response => {
        if(Response.data.registado === true){
          app.$router.push('/')
        } 
        else {
          this.showNotif(Response.data.mensagem)
        }
        console.log(Response)
      }).finally(function () {
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
  },
  setup(){
    api.get('/sanctum/csrf-cookie').then(Response => {
      console.log(Response)
    })
  }
};
</script>

<style>

    #formRegisto{
        width: 500px;
    }

</style>