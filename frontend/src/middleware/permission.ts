import { hasPermission } from '~/modules/shared/helpers/permissions'

export default defineNuxtRouteMiddleware((to) => {
  const requiredPermission = to.meta.permission as string | undefined

  if (requiredPermission && !hasPermission(requiredPermission)) {
    return navigateTo('/forbidden')
  }
})
