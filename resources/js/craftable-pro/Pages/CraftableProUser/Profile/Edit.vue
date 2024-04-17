<template>
  <CraftableProUserProfilePage v-bind="props" />
</template>

<script setup lang="ts">
import type { CraftableProUser } from "craftable-pro/types/models";
import CraftableProUserProfilePage from "craftable-pro/Pages/CraftableProUser/Profile/Edit.vue";

interface Props {
  craftableProUser: CraftableProUser;
  locales?: string[];
}

const props = defineProps<Props>();
</script>
