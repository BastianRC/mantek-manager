import type { UserRelation } from "~/modules/user/types/UserRelation";

export interface Chronology {
    id: number,
    user: UserRelation
    target_type: string
    target_id: number
    event_type: string,
    description: string,
    meta: string,
    created_at: string
}