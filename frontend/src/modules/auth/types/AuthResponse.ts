import type { Auth } from "./Auth";

export interface AuthResponse {
    token: string,
    user: Auth
}