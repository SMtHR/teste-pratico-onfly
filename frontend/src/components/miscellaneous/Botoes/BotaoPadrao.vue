<template>
  <v-btn
    :color="color ?? ''"
    :variant="hover ? 'flat' : 'outlined'"
    rounded
    border
    @mouseenter="hover = true"
    @mouseleave="hover = false"
    >{{ text ?? "text" }}</v-btn
  >
</template>

<script setup lang="ts">
import { ref } from "vue";

defineProps(["text", "color"]);

const hover = ref(false);
</script>

<style scoped></style>
