<template>
    <div class="space-y-4">
        <div v-for="(user) in role.users" :key="user.id"
            class="flex items-center justify-between p-4 border rounded-lg">
            <div class="flex items-center gap-3">
                <Avatar class="size-16">
                    <AvatarImage :src="user.avatar_url ?? ''" />
                    <AvatarFallback>{{ getInitials(`${user.first_name} ${user.last_name}`) }}</AvatarFallback>
                </Avatar>
                <div>
                    <p class="font-medium">{{ `${user.first_name} ${user.last_name}` }}</p>
                    <p class="text-sm text-muted-foreground">{{ user.email }}</p>
                    <p class="text-xs text-muted-foreground">
                        {{ user.department }}
                    </p>
                </div>
            </div>
        </div>

        <AlertMessage v-if="role.users ? false : true" title="Sin datos" message="¡Este rol no tiene usuarios asignados!" :icon="CircleAlert" variant="default" />
    </div>
</template>

<script setup lang="ts">
import Avatar from '~/components/ui/avatar/Avatar.vue';
import type { RoleDetails } from '../types/RoleDetails';
import AvatarImage from '~/components/ui/avatar/AvatarImage.vue';
import AvatarFallback from '~/components/ui/avatar/AvatarFallback.vue';
import { getInitials } from '~/lib/utils';
import AlertMessage from '~/components/custom/Alert/AlertMessage.vue';
import { CircleAlert } from 'lucide-vue-next';

defineProps<{
    role: RoleDetails
}>()
</script>

<style scoped></style>