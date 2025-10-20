<template>
  <v-container class="mt-3 border-b-md rounded-xl">
    <v-row class="px-12 align-center">
      <span class="text-h4">Onsky</span>
      <v-icon size="x-large">mdi-airplane</v-icon>
      <v-spacer></v-spacer>
      <v-btn flat icon color="transparent">
        <v-icon v-if="notificacaoStore.notificacoes.length === 0"
          >mdi-bell</v-icon
        >
        <v-badge
          v-else
          location="top right"
          color="error"
          :content="qtdNotificacoes()"
        >
          <v-icon>mdi-bell</v-icon>
        </v-badge>
        <v-menu
          activator="parent"
          location="bottom right"
          :close-on-content-click="false"
        >
          <CardNotificacao />
        </v-menu>
      </v-btn>
      <v-btn flat icon color="transparent">
        <v-icon>mdi-account</v-icon>
        <v-menu
          activator="parent"
          location="bottom right"
          :close-on-content-click="false"
        >
          <v-card class="px-6 py-2">
            <v-list>
              <div class="py-2">
                <span class="text-subtitle-2">
                  {{ usuario ?? "Usuário" }}
                </span>
                <br />
                <span class="text-caption">
                  {{ email ?? "Email" }}
                </span>
              </div>
              <v-divider></v-divider>
              <div
                class="text-button py-2 cursor-pointer"
                @click="authStore.logout()"
              >
                <v-icon class="mr-2">mdi-logout</v-icon>
                Logout
              </div>
            </v-list>
          </v-card>
        </v-menu>
      </v-btn>
    </v-row>
  </v-container>
</template>

<script setup lang="ts">
import { useAuthStore } from "@/stores/authStore";
import { useNotificacaoStore } from "@/stores/notificacaoStore";
import { computed } from "vue";

const authStore = useAuthStore();
const notificacaoStore = useNotificacaoStore();

const usuario = computed(() => localStorage.getItem("nome_usuario"));
const email = computed(() => localStorage.getItem("email_usuario"));

function qtdNotificacoes() {
  return notificacaoStore.notificacoes.length < 100
    ? notificacaoStore.notificacoes.length
    : "99+";
}
</script>
