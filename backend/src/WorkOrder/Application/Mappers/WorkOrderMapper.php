<?php

namespace Src\WorkOrder\Application\Mappers;

use Src\WorkOrder\Application\DTOs\AllWorkOrdersResponseDTO;
use Src\WorkOrder\Application\DTOs\DetailsWorkOrderResponseDTO;
use Src\WorkOrder\Application\DTOs\WorkOrderDetailsResponseDTO;
use Src\WorkOrder\Application\DTOs\WorkOrderResponseDTO;
use Src\WorkOrder\Domain\Entities\WorkOrder;

class WorkOrderMapper
{
    public static function toDto(WorkOrder $order, string $message = 'WorkOrder retrieved successfully.'): WorkOrderResponseDTO
    {
        return new WorkOrderResponseDto(
            success: true,
            message: $message,
            id: $order->getId(),
            orderNumber: $order->getOrderNumber(),
            title: $order->getTitle(),
            type: $order->getType(),
            description: $order->getDescription(),
            status: $order->getStatus(),
            priority: $order->getPriority(),
            dueAt: $order->getDueAt(),
            estimatedHours: $order->getEstimatedHours(),
            isStarted: $order->isStarted(),
            isPaused: $order->isPaused(),
            machine: $order->getMachine(),
            assignee: $order->getAssignee(),
            location: $order->getLocation(),
            createdAt: $order->getCreatedAt()
        );
    }

    public static function toDetailsDto(WorkOrder $order, string $message = 'WorkOrder retrieved successfully.'): WorkOrderDetailsResponseDTO
    {
        return new WorkOrderDetailsResponseDTO(
            success: true,
            message: $message,
            id: $order->getId(),
            orderNumber: $order->getOrderNumber(),
            title: $order->getTitle(),
            type: $order->getType(),
            description: $order->getDescription(),
            status: $order->getStatus(),
            priority: $order->getPriority(),
            dueAt: $order->getDueAt(),
            pausedAt: $order->getPausedAt(),
            startedAt: $order->getStartedAt(),
            completedAt: $order->getCompletedAt(),
            estimatedHours: $order->getEstimatedHours(),
            actualHours: $order->getActualHours(),
            isStarted: $order->isStarted(),
            isPaused: $order->isPaused(),
            machine: $order->getMachine(),
            assignee: $order->getAssignee(),
            location: $order->getLocation(),
            materials: $order->getMaterials(),
            requestedBy: $order->getRequestedBy(),
            approvedBy: $order->getApprovedBy(),
            notes: $order->getNotes(),
            createdBy: $order->getCreatedBy(),
            updatedBy: $order->getUpdatedBy(),
            createdAt: $order->getCreatedAt(),
            updatedAt: $order->getUpdatedAt()
        );
    }

    /**
     * @param WorkOrder[] $orders
     */
    public static function toCollection(array $orders): AllWorkOrdersResponseDTO
    {
        $dtos = array_map(
            fn(WorkOrder $order) => self::toDto($order),
            $orders
        );

        return new AllWorkOrdersResponseDTO(
            success: true,
            message: 'Work orders retrieved successfully.',
            orders: $dtos
        );
    }
}
