import type { User } from '../types/User'
import type { UserDetails } from '../types/UserDetails'

export function toUser(details: UserDetails): User {
    return {
        id: details.id,
        first_name: details.first_name,
        last_name: details.last_name,
        email: details.email,
        phone: details.phone,
        department: details.department,
        is_active: details.is_active,
        last_login: details.last_login ? new Date(details.last_login) : null,
    }
}

export function toUserList(detailsList: UserDetails[]): User[] {
    return detailsList.map(toUser)
}