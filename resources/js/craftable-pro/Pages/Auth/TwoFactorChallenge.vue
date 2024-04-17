<template>
  <TwoFactorChallengePage v-bind="props" />
</template>

<script setup lang="ts">
import TwoFactorChallengePage from "craftable-pro/Pages/Auth/TwoFactorChallenge.vue";

interface Props {
  canResetPassword: boolean;
}

const props = defineProps<Props>();
</script>
