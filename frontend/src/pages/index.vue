<route lang="yaml">
meta:
  requiresAuth: true
</route>

<template>
  <v-container fluid width="80%">
    <Navbar />
    <v-row>
      <Contadores />
      <TabelaPedidos />
    </v-row>
    <v-snackbar-queue
      v-model="notificacaoStore.snackbar.messages"
      timeout="4500"
      :color="notificacaoStore.snackbar.color"
      location="bottom right"
    >
    </v-snackbar-queue>
  </v-container>
</template>

<script lang="ts" setup>
import { useNotificacaoStore } from "@/stores/notificacaoStore";
import { onMounted } from "vue";

const notificacaoStore = useNotificacaoStore();

onMounted(() => {
  notificacaoStore.buscarNotificacoes();
});
</script>
