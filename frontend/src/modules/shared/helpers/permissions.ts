import { useAuthStore } from "~/modules/auth/stores/auth"
import type { Auth } from "~/modules/auth/types/Auth"

export const hasPermission = (permission: string, user?: Auth | null): boolean => {
    const u = user ?? useAuthStore().user
    return u?.permissions?.includes(permission) ?? false
}