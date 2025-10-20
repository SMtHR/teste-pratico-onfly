<route lang="yaml">
meta:
  layout: clean
</route>

<template>
  <v-container
    fluid
    width="80%"
    class="d-flex justify-center align-center h-screen"
  >
    <v-row class="align-center justify-center">
      <v-col cols="5">
        <v-card class="text-center elevation-4">
          <v-card-title primary-title class="text-h3"> Onsky </v-card-title>
          <v-card-title class="text-subtitle"> Login </v-card-title>
          <v-card-text>
            <v-text-field
              v-model="authStore.loginForm.email"
              label="E-mail"
              variant="outlined"
              density="compact"
              width="100%"
              autocomplete="off"
              clearable
              rounded
              class="mb-4"
            ></v-text-field>

            <v-text-field
              v-model="authStore.loginForm.password"
              label="Senha"
              variant="outlined"
              density="compact"
              width="100%"
              autocomplete="off"
              type="password"
              clearable
              rounded
              class="mb-4"
            ></v-text-field>
            <BotaoPadrao
              text="Login"
              color="info"
              class="w-100"
              @click="authStore.login()"
            />
            <BotaoPadrao
              to="registrar"
              text="Registrar"
              color=""
              class="w-100 mt-4"
            />
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script lang="ts" setup>
import { useAuthStore } from "@/stores/authStore";

const authStore = useAuthStore();
</script>
