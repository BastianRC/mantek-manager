import type { Permission } from "./Permission";
import type { UserDetails } from "~/modules/user/types/UserDetails";

export interface RoleDetails {
    id: number,
    name: string,
    description: string,
    color: string,
    is_active: boolean,
    permissions: Permission[],
    users: UserDetails[],
    created_by: {
        id: number,
        name: string
    },
    updated_by: {
        id: number,
        name: string
    },
    created_at: Date,
    updated_at: Date
}