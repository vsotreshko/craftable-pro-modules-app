<template>
  <CraftableProUserEditPage v-bind="props" />
</template>

<script setup lang="ts">
import CraftableProUserEditPage from "craftable-pro/Pages/CraftableProUser/Edit.vue";
import type { CraftableProUser, Role } from "craftable-pro/types/models";

interface Props {
  craftableProUser: CraftableProUser;
  roles: Role[];
  locales: string[];
}

const props = defineProps<Props>();
</script>
