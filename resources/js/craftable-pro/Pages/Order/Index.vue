<template>
    <div class="flex flex-col">
        <template v-if="modules?.includes('laravel-composer-package-module')">
            <div>Code for laravel-composer-package-module</div>

            <SomeComponent />
        </template>

        <template v-if="modules?.includes('not-existing-module')">
            Code for not-existing-module

            <NotExistingComponent />
        </template>
    </div>
</template>

<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";

const modules = usePage().props?.modules as string[];
</script>
