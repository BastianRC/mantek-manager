<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button variant="outline" @click="emit('open')">
                <Plus />
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-80">
            <slot></slot>
        </PopoverContent>
    </Popover>
</template>

<script setup lang="ts">
import { Plus } from 'lucide-vue-next';
import Button from '~/components/ui/button/Button.vue';
import Popover from '~/components/ui/popover/Popover.vue';
import PopoverContent from '~/components/ui/popover/PopoverContent.vue';
import PopoverTrigger from '~/components/ui/popover/PopoverTrigger.vue';

const emit = defineEmits(['open'])

</script>

<style scoped></style>