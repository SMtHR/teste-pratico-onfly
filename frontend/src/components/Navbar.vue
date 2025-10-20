<template>
  <v-row no-gutters class="align-center">
    <v-col cols="4" class="">
      <span class="text-h5">Dashboard</span>
      <v-divider></v-divider>
      <span class="text-overline font-weight-light"
        >Bem vindo(a), {{ usuario ?? "Usuário" }}</span
      >
    </v-col>
    <v-col cols="5"></v-col>
    <v-col cols="3">
      <v-text-field
        v-model="pedidoStore.campoPesquisa"
        label="Pesquise aqui"
        variant="outlined"
        density="compact"
        autocomplete="off"
        hide-details
        clearable
        rounded
      ></v-text-field>
    </v-col>
  </v-row>
</template>

<script setup lang="ts">
import { usePedidoStore } from "@/stores/pedidoStore";
import { computed } from "vue";

const pedidoStore = usePedidoStore();

const usuario = computed(() => localStorage.getItem("nome_usuario"));
</script>

<style scoped></style>
