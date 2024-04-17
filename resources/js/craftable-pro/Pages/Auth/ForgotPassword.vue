<template>
  <ForgotPasswordPage v-bind="props" />
</template>

<script setup lang="ts">
import ForgotPasswordPage from "craftable-pro/Pages/Auth/ForgotPassword.vue";

interface Props {
  status: string;
}

const props = defineProps<Props>();
</script>
