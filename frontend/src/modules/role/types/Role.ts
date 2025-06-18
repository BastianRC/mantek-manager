import type { UserDetails } from "~/modules/user/types/UserDetails";
import type { Permission } from "./Permission";

export interface Role {
    id: number,
    name: string,
    description: string,
    color: string,
    is_active: boolean,
    permissions: Permission[],
    users: UserDetails[],
    created_at: Date,
    updated_at: Date
}