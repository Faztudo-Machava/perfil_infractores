<template>
  <q-page class="q-my-md q-mx-md">
    <q-splitter horizontal>
      <template v-slot:before>
        <div class="col q-my-md">
          <q-select
            filled
            bottom-slots
            v-model="regra"
            :options="opcoes"
            behavior="menu"
            emit-value
          >
            <template v-slot:prepend>
              <q-icon name="traffic" />
            </template>
          </q-select>
          <q-btn
            flat
            type="submit"
            color="white"
            class="bg-primary btn-sm"
            @click="pegarPerfil"
            ><q-icon name="search" />
            </q-btn
          >
        </div>
      </template>
      <template v-slot:after>
        <div class="q-my-md col">
          <div class="col flex flex-center">
            <q-icon name="person" color="grey" style="font-size: 200px" />
          </div>
          <div class="flex flex-center col">
            <div class="row">
              <q-item class="q-mx-md q-my-md">
                <q-item-section avatar>
                  <q-avatar>
                    <q-icon name="date_range" />
                  </q-avatar>
                </q-item-section>
                <q-item-section>
                  <q-item-label lines="1">Idade</q-item-label>
                  <q-item-label caption lines="2">{{
                    perfil.idade
                  }}</q-item-label>
                </q-item-section>
              </q-item>

              <q-item class="q-mx-md q-my-md">
                <q-item-section avatar>
                  <q-avatar>
                    <q-icon name="category" />
                  </q-avatar>
                </q-item-section>
                <q-item-section>
                  <q-item-label lines="1">Categoria</q-item-label>
                  <q-item-label caption lines="2">{{
                    perfil.categoria
                  }}</q-item-label>
                </q-item-section>
              </q-item>
              <q-item class="q-mx-md q-my-md">
                <q-item-section avatar>
                  <q-avatar>
                    <q-icon name="person" />
                  </q-avatar>
                </q-item-section>
                <q-item-section>
                  <q-item-label lines="1">Genero</q-item-label>
                  <q-item-label caption lines="2">{{
                    perfil.genero
                  }}</q-item-label>
                </q-item-section>
              </q-item>

              <q-item class="q-mx-md q-my-md">
                <q-item-section avatar>
                  <q-avatar>
                    <q-icon name="healthy" />
                  </q-avatar>
                </q-item-section>
                <q-item-section>
                  <q-item-label lines="1">Deficiente</q-item-label>
                  <q-item-label caption lines="2">{{
                    perfil.condicao == 0 ? "não" : "sim"
                  }}</q-item-label>
                </q-item-section>
              </q-item>
            </div>
          </div>
        </div>
      </template>
    </q-splitter>
  </q-page>
</template>

<script>
import { api } from "boot/axios";
import {ref} from 'vue'
import { Loading, QSpinnerGears } from "quasar";

export default {
  name: "perfil",
  data() {
    return {
      regra: "Selecione a regra de transito",
      opcoes: [],
      allPerfil: [],
      perfil: {
        idade: "",
        genero: "",
        condicao: 0,
        categoria: "",
      },
    };
  },
  methods: {
    addOpcoes(nome) {
      this.opcoes.push(nome);
    },
    pegarPerfil() {

      Loading.show()
      for (let i = 0; i < this.allPerfil.length; i++) {
        if (this.allPerfil[i].regra == this.regra) {
          this.perfil.idade = this.allPerfil[i].media;
          this.perfil.genero = this.allPerfil[i].genero;
          this.perfil.condicao = this.allPerfil[i].condicao;
          this.perfil.categoria = this.allPerfil[i].categoria;
        }
      }
      Loading.hide()
    },
  },
  mounted() {
    api.get("/api/regra").then((Response) => {
      Response.data.forEach((dados) => {
        this.addOpcoes(dados.nome);
      });
    });

    api.get("/api/Perfil").then((response) => {
      this.allPerfil = response.data;
      console.log(this.allPerfil);
    });

    api.get("/sanctum/csrf-cookie").then((Response) => {
      console.log(Response);
    });
  },
};
</script>

<style>
</style>