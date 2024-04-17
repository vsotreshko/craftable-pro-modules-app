<template>
  <RoleIndexPage v-bind="props" />
</template>

<script setup lang="ts">
import RoleIndexPage from "craftable-pro/Pages/Roles/Index.vue";
import { PaginatedCollection } from "craftable-pro/types/pagination";
import type { Role } from "craftable-pro/types/models";

interface Props {
  roles: PaginatedCollection<Role>;
}

const props = defineProps<Props>();

</script>
