
import type { MachineRelation } from "~/modules/machine/types/MachineRelation";
import type { WorkOrderRelation } from "~/modules/work-order/types/WorkOrderRelation";

export interface Location {
    id: number;
    name: string;
    type: string;
    description: string;
    address: string;
    manager_name: string | null;
    is_active: boolean;
    machines: MachineRelation[]
    work_orders: WorkOrderRelation[];
    created_at: Date | null;
    updated_at: Date | null;
}

export type BasicLocation = Pick<Location, 'id' | 'name'>