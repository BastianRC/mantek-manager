<?php

namespace Src\Machine\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Machine\Domain\ValueObject\MachineDocumentFileSize;
use Src\Machine\Domain\ValueObject\MachineDocumentMimeType;

class UploadMachineDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'machine_id' => ['required', 'integer', 'exists:machines,id'],
            'document_name' => ['required', 'string', 'max:255'],
            'document_file' => [
                'required',
                'file',
                'mimetypes:' . implode(',', MachineDocumentMimeType::allowed()),
                'max:' . MachineDocumentFileSize::maxKilobytes()
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'machine_id.required' => 'The machine ID is required.',
            'machine_id.integer' => 'The machine ID must be an integer.',
            'machine_id.exists' => 'The selected machine does not exist.',

            'document_name.required' => 'The document name is required.',
            'document_name.string' => 'The document name must be a string.',
            'document_name.max' => 'The document name must not exceed 255 characters.',

            'document.required' => 'The document file is required.',
            'document.file' => 'The document must be a valid file.',
            'document.mimetypes' => 'The document must be of an allowed MIME type.',
            'document.max' => 'The document must not exceed ' . MachineDocumentFileSize::maxKilobytes() . ' kilobytes.',
        ];
    }
}
