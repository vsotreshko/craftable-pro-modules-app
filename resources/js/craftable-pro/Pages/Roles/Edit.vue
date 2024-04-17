<template>
  <RoleEditPage v-bind="props" />
</template>

<script setup lang="ts">
import type { Role } from "craftable-pro/types/models";
import RoleEditPage from "craftable-pro/Pages/Roles/Edit.vue";

interface Props {
  role: Role
  permissionsTree: any
}

const props = defineProps<Props>();
</script>
