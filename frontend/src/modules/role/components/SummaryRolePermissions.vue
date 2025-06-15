<template>
    <div v-for="(category, categoryKey) in PERMISSION_CATEGORIES" :key="categoryKey"
        class="flex items-center justify-between">
        <span class="text-sm">{{ category.name }}</span>
        <div class="flex items-center gap-1">
            <span class="text-sm font-medium">
                {{ categoryPermissions(category).length }}/{{ category.permissions.length }}
            </span>
            <Check v-if="categoryPermissions(category).length === category.permissions.length"
                class="h-4 w-4 text-green-600" />
        </div>
    </div>
</template>

<script setup lang="ts">
import { PERMISSION_CATEGORIES } from '~/modules/shared/constants/permissions';
import type { RoleDetails } from '../types/RoleDetails';
import { Check } from 'lucide-vue-next';

const props = defineProps<{
    role: RoleDetails
}>()

const categoryPermissions = (category: any) =>
    category.permissions.filter(p =>
        props.role.permissions.some(r => r.name === p.id)
    );

</script>

<style scoped></style>