import { ref } from 'vue'

export interface ConfirmDialogOptions {
    title: string
    description?: string
    cancelText?: string
    actionText?: string
}

const isOpen: Ref<boolean> = ref(false)
const options: Ref<ConfirmDialogOptions> = ref<ConfirmDialogOptions>({
    title: '',
    description: '',
    cancelText: 'Cancelar',
    actionText: 'Confirmar'
})

let resolver: (value: boolean) => void

export function useConfirmDialog() {
    const open = (opts: ConfirmDialogOptions): Promise<boolean> => {
        options.value = {
            cancelText: 'Cancelar',
            actionText: 'Confirmar',
            ...opts
        }
        isOpen.value = true

        return new Promise(resolve => {
            resolver = resolve
        })
    }

    const confirm = () => {
        isOpen.value = false
        resolver(true)
    }

    const cancel = () => {
        isOpen.value = false
        resolver(false)
    }

    return {
        isOpen,
        options,
        open,
        confirm,
        cancel
    }
}
