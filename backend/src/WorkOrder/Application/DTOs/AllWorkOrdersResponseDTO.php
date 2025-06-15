<?php

namespace Src\WorkOrder\Application\DTOs;

use Src\Shared\Application\DTOs\BaseResponseDto;

class AllWorkOrdersResponseDTO extends BaseResponseDto
{
    /**
     * @param WorkOrderResponseDto[] $orders
     */
    public function __construct(
        bool $success,
        string $message,
        public array $orders
    ) {
        parent::__construct($success, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => array_map(
                fn(WorkOrderResponseDto $dto) => $dto->toArray()['data'],
                $this->orders
            ),
        ];
    }
}
