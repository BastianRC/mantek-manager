<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle
} from '@/components/ui/alert-dialog'

import { useConfirmDialog } from './useConfirmDialog';

const dialog = useConfirmDialog()
</script>

<template>
    <AlertDialog :open="dialog.isOpen.value">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>{{ dialog.options.value.title }}</AlertDialogTitle>
                <AlertDialogDescription v-if="dialog.options.value.description">
                    {{ dialog.options.value.description }}
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel @click="dialog.cancel">
                    {{ dialog.options.value.cancelText }}
                </AlertDialogCancel>
                <AlertDialogAction @click="dialog.confirm">
                    {{ dialog.options.value.actionText }}
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
