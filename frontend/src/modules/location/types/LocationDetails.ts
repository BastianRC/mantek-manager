import type { User } from "~/modules/user/types/User";
import type { LocationZone } from "./LocationZone";
import type { LocationSystem } from "./LocationSystem";
import type { WorkOrder } from "~/modules/work-order/types/WorkOrder";
import type { MachineDetails } from "~/modules/machine/types/MachineDetails";
import type { MachineRelation } from "~/modules/machine/types/MachineRelation";
import type { WorkOrderRelation } from "~/modules/work-order/types/WorkOrderRelation";

export interface LocationDetails {
    id: number;
    name: string;
    type: string;
    description: string;
    address: string;
    floor?: number | null;
    latitude?: number | null;
    longitude?: number | null;
    manager?: User | null;
    emergency_contact?: string | null;
    emergency_phone?: string | null;
    access_requirements?: string | null;
    operating_hours?: string | null;
    notes?: string | null;
    is_active: boolean;
    created_by?: User | null;
    updated_by?: User | null;
    created_at: Date | null;
    updated_at: Date | null;
    zones?: LocationZone[] | null;
    systems?: LocationSystem[] | null;
    machines: MachineRelation[],
    work_orders: WorkOrderRelation[]
}