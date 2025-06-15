const editMode: Ref<boolean> = ref(false)

export const useEditMode = () => {
    const setEditMode = (value: boolean) => {
        editMode.value = value
    }

    const clearEditMode = () => {
        editMode.value = false
    }

    return {
        editMode: readonly(editMode),
        setEditMode,
        clearEditMode
    }
}