<template>
  <v-col cols="9" class="">
    <v-card
      width="100%"
      variant="outlined"
      class="my-4 pa-2 d-flex flex-column align-center rounded-lg"
    >
      <v-data-table
        :headers="headersConfig"
        :header-props="headersStyle"
        :items="pedidoStore.pedidos"
        items-per-page="10"
        :search="pedidoStore.campoPesquisa"
        :loading="pedidoStore.loading"
        striped="odd"
        density="comfortable"
        fixed-header
        height="500"
      >
        <template #item.actions="{ item }">
          <BotaoTableAction
            icon="mdi-check"
            color="success"
            class="mr-1"
            @click="
              () => {
                pedidoStore.isAprovarPedidoOpen = true;
                pedidoStore.pedidoSelecionado = item;
              }
            "
          />
          <BotaoTableAction
            icon="mdi-close"
            color="error"
            class="ml-1"
            @click="
              () => {
                pedidoStore.isCancelarPedidoOpen = true;
                pedidoStore.pedidoSelecionado = item;
              }
            "
          />
        </template>

        <template #loading>
          <div
            class="d-flex justify-center align-center h-100 w-100 position-absolute top-0 left-0 bg-surface"
          >
            <v-progress-circular indeterminate color="primary" size="64" />
          </div>
        </template>
      </v-data-table>
    </v-card>
  </v-col>

  <ModalAprovarPedido v-model="pedidoStore.isAprovarPedidoOpen" />
  <ModalCancelarPedido v-model="pedidoStore.isCancelarPedidoOpen" />
</template>

<script setup lang="ts">
import { usePedidoStore } from "@/stores/pedidoStore";
import { onMounted } from "vue";
import type { DataTableHeader } from "vuetify";

const headersConfig = [
  { title: "Solicitante", key: "nome_cliente", align: "start", width: "10%" },
  { title: "Destino", key: "destino", align: "start", width: "20%" },
  { title: "Data de Ida", key: "dt_ida", align: "start", width: "15%" },
  { title: "Data da Volta", key: "dt_volta", align: "start", width: "15%" },
  { title: "Status", key: "status", align: "start", width: "15%" },
  { title: "Ações", key: "actions", align: "center", width: "15%" },
] as const;

const headersStyle = { class: "bg-primary text-uppercase" };

const pedidoStore = usePedidoStore();

onMounted(() => {
  pedidoStore.buscarPedidos();
});
</script>

<style scoped></style>
