<template>
  <v-btn
    icon
    size="x-small"
    :color="color ?? ''"
    :variant="hover ? 'flat' : 'outlined'"
    @mouseenter="hover = true"
    @mouseleave="hover = false"
  >
    <v-icon>{{ icon }}</v-icon>
  </v-btn>
</template>

<script setup lang="ts">
import { ref } from "vue";

defineProps(["icon", "color"]);

const hover = ref(false);
</script>

<style scoped></style>
