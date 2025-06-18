import { toast } from "vue-sonner";
import { useLogout } from "~/modules/auth/composables/useLogout";
import { useAuthStore } from "~/modules/auth/stores/auth";
import { DASHBOARD_REDIRECTS } from "~/modules/shared/constants/redirects";

export default defineNuxtRouteMiddleware(async (to) => {
  const auth = useAuthStore();

  if (!auth.isAuthenticated) {
    return navigateTo("/login");
  }

  if (to.path === "/dashboard") {
    const permissions = auth.user?.permissions ?? [];

    for (const option of DASHBOARD_REDIRECTS) {
      if (permissions.includes(option.permission)) {
        return navigateTo(option.path);
      }
    }

    const { mutate: logout } = useLogout();
    logout();
  }
});
