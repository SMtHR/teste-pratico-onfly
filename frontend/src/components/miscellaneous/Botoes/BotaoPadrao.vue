<template>
  <v-btn
    :type="type ?? 'button'"
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

defineProps(["text", "color", "type"]);

const hover = ref(false);
</script>

<style scoped></style>
