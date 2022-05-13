<template>
  <q-layout view="hHh lpR fFf">
    <q-header elevated>
      <q-toolbar>
        <q-toolbar-title class="absolute-center">
          Perfil de infratorres
        </q-toolbar-title>
      </q-toolbar>
    </q-header>
    <q-footer>
      <q-tabs>
        <q-route-tab
          v-for="link in links"
          v-bind:key="link.title"
          :to="link.link"
          :name="link.icon"
          :icon="link.icon"
          :label="link.title"
        />
      </q-tabs>
    </q-footer>
    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      :breakpoint="767"
      :width="250"
      bordered
      class="bg-primary"
    >
      <q-list dark>
        <q-item-label header class="text-white"> Menu </q-item-label>
        <Link
          v-for="link in links"
          :key="link.title"
          v-bind="link"
          class="text-grey-4"
        />
      </q-list>
    </q-drawer>
    
    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import Link from "components/EssentialLink.vue";

const linksData = [
  {
    title: "Perfil",
    icon: "person",
    link: "/perfil",
  },
  {
    title: "Regras de transito",
    icon: "traffic",
    link: "/regra",
  },
  {
    title: "Sair",
    icon: "logout",
    link: "/",
  }
];

export default {
  name: "Layout",
  components: { Link },
  data() {
    return {
      leftDrawerOpen: false,
      links: linksData,
    };
  },
};
</script>
<style>
@media screen and (min-width: 768px) {
  .q-footer {
    display: none;
  }

  .q-drawer .q-router-link--exact-active {
    color: white !important;
  }
}
</style>
