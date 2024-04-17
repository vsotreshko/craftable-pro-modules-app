<template>
  <div class="divide-y divide-gray-100">
    <div class="py-1">
      <DropdownItem class="font-medium text-gray-900">
        <div class="text-ellipsis overflow-hidden">
          {{ user?.email }}
        </div>
      </DropdownItem>
    </div>
    <div class="py-1">
      <DropdownItem :close-after-click="true"  href="/admin/profile">
        {{ $t("craftable-pro", "Profile") }}
      </DropdownItem>
      <DropdownItem :close-after-click="true"  href="/admin/password">
        {{ $t("craftable-pro", "Password") }}
      </DropdownItem>
    </div>
  </div>
</template>

<script setup lang="ts">
import { DropdownItem } from "craftable-pro/Components";
import { useUser } from "craftable-pro/hooks/useUser";

const { user } = useUser();
</script>
