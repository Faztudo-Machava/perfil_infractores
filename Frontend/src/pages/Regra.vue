<template>
  <q-page class="q-my-md q-mx-md">
    <q-table
      title="Regras de transito"
      :rows="linhas"
      :columns="colunas"
      row-key="name"
    />
  </q-page>
</template>

<script>
import { api } from "boot/axios";

const colunas = [
  {
    name: "regra",
    required: "true",
    label: "Regras",
    align: "left",
    field: (linhas) => linhas.name,
    sortable: true,
  },
  {
    name: "descricao",
    required: "true",
    label: "Descrição",
    align: "left",
    field: (linhas) => linhas.descricao,
    sortable: true,
  },
];

const linhas = [];

api.get("/sanctum/csrf-cookie").then((Response) => {});

api.get("/api/regra").then((Response) => {
  Response.data.forEach((dados) => {
    linhas.push({ name: dados.nome, descricao: dados.descricao });
  });
});

export default {
  setup() {
    return {
      colunas,
      linhas,
    };
  }
};
</script>

<style>
</style>