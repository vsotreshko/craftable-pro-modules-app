<template>
  <CraftableProUserPasswordPage v-bind="props" />
</template>

<script setup lang="ts">
import type { CraftableProUser } from "craftable-pro/types/models";
import CraftableProUserPasswordPage from "craftable-pro/Pages/CraftableProUser/Password/Edit.vue";

interface Props {
  craftableProUser: CraftableProUser;
}

const props = defineProps<Props>();
</script>
