<template>
  <v-dialog
    v-model="pedidoStore.isCriarPedidoOpen"
    max-width="40%"
    transition="dialog-transition"
  >
    <v-card width="100%" class="pa-4">
      <v-card-title class="ml-7"> Criar Pedido </v-card-title>
      <v-card-subtitle class="ml-7">
        Informe os dados abaixo para criar um novo pedido
      </v-card-subtitle>
      <v-card-text class="px-10">
        <!-- <v-text-field
          v-model="authStore.usuario.usuario"
          label="Nome do Solicitante"
          variant="outlined"
          density="compact"
          width="100%"
          autocomplete="off"
          hint="Não se preocupe, este campo é preenchido automaticamente com o seu nome de usuário"
          readonly
          persistent-hint
          rounded
          class="mb-4"
        ></v-text-field> -->
        <v-text-field
          v-model="pedidoStore.criarPedidoForm.destino"
          label="Destino"
          variant="outlined"
          density="compact"
          width="100%"
          autocomplete="off"
          clearable
          rounded
          class="my-4"
        ></v-text-field>
        <v-row no-gutters>
          <v-date-input
            v-model="pedidoStore.criarPedidoForm.dt_ida"
            variant="outlined"
            density="compact"
            clearable
            rounded
            :min="new Date()"
            :max="pedidoStore.criarPedidoForm.dt_volta"
            prepend-icon=""
            prepend-inner-icon="$calendar"
            label="Data de ida"
            class="mx-1"
          >
          </v-date-input>
          <v-date-input
            v-model="pedidoStore.criarPedidoForm.dt_volta"
            variant="outlined"
            density="compact"
            clearable
            rounded
            :min="pedidoStore.criarPedidoForm.dt_ida"
            :disabled="!pedidoStore.criarPedidoForm.dt_ida"
            prepend-icon=""
            prepend-inner-icon="$calendar"
            label="Data da volta"
            class="mx-1"
          >
          </v-date-input>
        </v-row>
      </v-card-text>
      <v-card-actions class="px-10">
        <BotaoPadrao
          text="Voltar"
          color=""
          @click="pedidoStore.isCriarPedidoOpen = false"
        />
        <BotaoPadrao
          text="Confirmar"
          color="info"
          @click="pedidoStore.criarPedido()"
        />
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { useAuthStore } from "@/stores/authStore";
import { usePedidoStore } from "@/stores/pedidoStore";

const pedidoStore = usePedidoStore();
const authStore = useAuthStore();
</script>

<style scoped></style>
