<template>
    <PermissionIndexPage v-bind="props" />
</template>

<script setup lang="ts">
import PermissionIndexPage from "craftable-pro/Pages/Permissions/Index.vue";
import type { Role } from "craftable-pro/types/models";

interface Props {
    roles: Role[];
    permissions: [];
}

const props = defineProps<Props>();
</script>
