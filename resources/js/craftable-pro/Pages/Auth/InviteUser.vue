<template>
    <InviteUserCreate v-bind="props" />
</template>

<script setup lang="ts">
import InviteUserCreate from "craftable-pro/Pages/Auth/InviteUser.vue"

interface Props {
  email: string;
}

const props = defineProps<Props>();
</script>
