<template>
  <CraftableProUserPage v-bind="props" />
</template>

<script setup lang="ts">
import CraftableProUserPage from "craftable-pro/Pages/CraftableProUser/Index.vue";
import { PaginatedCollection } from "craftable-pro/types/pagination";
import type { CraftableProUser, Role } from "craftable-pro/types/models";

interface Props {
  craftableProUsers: PaginatedCollection<CraftableProUser>;
  roles: Role[];
  filterOptions: {
    roles: string[];
  };
}

const props = defineProps<Props>();
</script>
