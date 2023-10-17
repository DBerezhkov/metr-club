<?php

namespace App\Http\Requests\Partner\Api;

use App\Rules\MaxUploadedFileSize;
use Illuminate\Foundation\Http\FormRequest;

class SendNewFilesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'banks' => 'required',
            'scanfiles' => ['required', new MaxUploadedFileSize(30000)],
            'scanfiles.*' => 'mimetypes:image/png,image/jpeg,application/pdf,image/tiff,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/x-rar-compressed,application/vnd.rar,application/zip,application/octet-stream,application/x-zip-compressed,multipart/x-zip,application/x-rar,
            application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document|max:20000',
        ];
    }
}
