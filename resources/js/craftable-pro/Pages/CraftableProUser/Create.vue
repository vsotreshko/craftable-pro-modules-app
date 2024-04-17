<template>
  <CraftableProUserCreatePage v-bind="props" />
</template>

<script setup lang="ts">
import CraftableProUserCreatePage from "craftable-pro/Pages/CraftableProUser/Create.vue";
import type { Role } from "craftable-pro/types/models";

interface Props {
  roles: Role[];
  locales: string[];
  defaultLocale: string;
}

const props = defineProps<Props>();
</script>
