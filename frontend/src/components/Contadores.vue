<template>
  <v-col cols="3" class="d-flex flex-column">
    <v-card
      width="100%"
      variant="outlined"
      class="my-4 pa-2 d-flex flex-column align-center rounded-lg"
    >
      <span class="pa-2 font-weight-light">Pedidos criados</span>
      <span class="pa-1 text-h3">{{ qtdPedidosCriados }}</span>
    </v-card>
    <v-card
      width="100%"
      variant="outlined"
      class="my-4 pa-2 d-flex flex-column align-center rounded-lg"
    >
      <span class="pa-2 font-weight-light">Pedidos aprovados</span>
      <span class="pa-1 text-h3">{{ qtdPedidosAprovados }}</span>
    </v-card>
    <v-card
      width="100%"
      variant="outlined"
      class="my-4 pa-2 d-flex flex-column align-center rounded-lg"
    >
      <span class="pa-2 font-weight-light">Pedidos cancelados</span>
      <span class="pa-1 text-h3">{{ qtdPedidosCancelados }}</span>
    </v-card>
    <v-spacer></v-spacer>
    <v-btn
      color="info"
      prepend-icon="mdi-plus"
      rounded="xl"
      class="my-4"
      @click="pedidoStore.isCriarPedidoOpen = true"
    >
      Criar Pedido
    </v-btn>
  </v-col>
  <ModalCriarPedido />
</template>

<script setup lang="ts">
import { usePedidoStore } from "@/stores/pedidoStore";
import { computed } from "vue";

const pedidoStore = usePedidoStore();
const qtdPedidosCriados = computed(() => pedidoStore.pedidos.length);
const qtdPedidosAprovados = computed(
  () => pedidoStore.pedidos.filter((p: any) => p.status === "Aprovado").length
);
const qtdPedidosCancelados = computed(
  () => pedidoStore.pedidos.filter((p: any) => p.status === "Cancelado").length
);
</script>

<style scoped></style>
