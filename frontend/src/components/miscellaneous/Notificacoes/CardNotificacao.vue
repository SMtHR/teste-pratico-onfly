<template>
  <v-card class="px-4 py-2">
    <v-row no-gutters class="align-center">
      <span class="font-weight-light">Notificações</span>
      <v-spacer></v-spacer>
      <v-btn
        v-if="notificacaoStore.notificacoes.length > 0"
        size="small"
        icon
        flat
        @click="notificacaoStore.marcarTodasComoLidas()"
      >
        <v-icon>mdi-check-all</v-icon>
      </v-btn>
    </v-row>
    <v-divider></v-divider>
    <v-list density="comfortable" class="my-1" nav lines="three">
      <span
        v-if="notificacaoStore.notificacoes.length === 0"
        class="text-caption"
      >
        Não há nenhuma notificação por enquanto
      </span>
      <v-list-item
        v-for="notificacao in notificacaoStore.notificacoes"
        :key="notificacao.id"
        class="elevation-3"
      >
        <div v-if="notificacao.data.status === 'Aprovado'">
          <div class="v-list-item-title font-weight-bold mb-1">
            <v-icon size="small" color="success" class="mr-2"
              >mdi-airplane-check
            </v-icon>
            Pedido Aprovado
          </div>
          <div class="v-list-item-subtitle mb-1">
            {{ notificacao.data.mensagem }}
          </div>
          <div class="text-caption text-medium-emphasis">
            {{ notificacao.data.data }}
          </div>
        </div>

        <div v-if="notificacao.data.status === 'Cancelado'">
          <div class="v-list-item-title font-weight-bold mb-1">
            <v-icon size="small" color="error" class="mr-2"
              >mdi-airplane-remove
            </v-icon>
            Pedido Cancelado
          </div>
          <div class="v-list-item-subtitle mb-1">
            {{ notificacao.data.mensagem }}
          </div>
          <div class="text-caption text-medium-emphasis">
            {{ notificacao.data.data }}
          </div>
        </div>

        <template #append>
          <v-divider vertical class="ml-3 mr-1"></v-divider>
          <v-btn
            icon
            flat
            size="small"
            @click="notificacaoStore.marcarComoLida(notificacao.id)"
          >
            <v-icon>mdi-check</v-icon>
          </v-btn>
        </template>
      </v-list-item>
    </v-list>
  </v-card>
</template>

<script setup lang="ts">
import { useNotificacaoStore } from "@/stores/notificacaoStore";

const notificacaoStore = useNotificacaoStore();
</script>

<style scoped></style>
