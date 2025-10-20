<template>
  <v-dialog
    v-model="pedidoStore.isCancelarPedidoOpen"
    max-width="40%"
    transition="dialog-transition"
  >
    <v-card width="100%" class="pa-1">
      <v-card-title class="ml-7"> Cancelar Pedido </v-card-title>
      <v-card-text class="px-10">
        Você tem certeza que deseja cancelar este pedido?
      </v-card-text>
      <v-card-actions class="px-10">
        <BotaoPadrao
          text="Voltar"
          color=""
          @click="pedidoStore.isCancelarPedidoOpen = false"
        />
        <BotaoPadrao
          text="Confirmar"
          color="info"
          @click="pedidoStore.cancelarPedido()"
        />
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { usePedidoStore } from "@/stores/pedidoStore";

defineProps(["item"]);
const pedidoStore = usePedidoStore();
</script>

<style scoped></style>
