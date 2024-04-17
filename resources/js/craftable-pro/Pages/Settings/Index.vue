<template>
  <IndexPage v-bind="$props" />
</template>

<script lang="ts" setup>

import IndexPage from "craftable-pro/Pages/Settings/Index.vue";
import {GeneralSettings} from "craftable-pro/Pages/Settings/types";

interface Props {
  generalSettings: GeneralSettings;
  availableRoutes: string[];
}

defineProps<Props>();

</script>
