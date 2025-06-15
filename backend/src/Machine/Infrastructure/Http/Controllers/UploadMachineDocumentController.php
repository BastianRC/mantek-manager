<?php

namespace Src\Machine\Infrastructure\Http\Controllers;

use Src\Machine\Application\DTOs\UploadMachineDocumentRequestDTO;
use Src\Machine\Application\UseCases\UploadMachineDocumentUseCase;
use Src\Machine\Infrastructure\Http\Requests\UploadMachineDocumentRequest;

class UploadMachineDocumentController
{
    public function __invoke(UploadMachineDocumentRequest $request, UploadMachineDocumentUseCase $useCase)
    {
        $file = $request->file('document_file');

        $dto = new UploadMachineDocumentRequestDTO(
            machineId: $request->input('machine_id'),
            documentName: $request->input('document_name'),
            fileSize: $file->getSize(),
            fileContent: file_get_contents($file->getRealPath()),
            mimeType: $file->getMimeType(),
            uploadedById: $request->user()->id
        );

        $response = $useCase->execute($dto);

        return response()->json($response->toArray(), 201);
    }
}
