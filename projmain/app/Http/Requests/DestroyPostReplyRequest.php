<?php

namespace App\Http\Requests;

use App\Models\PostReply;
use Illuminate\Foundation\Http\FormRequest;

class DestroyPostReplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('delete', PostReply::find($this->route('postReply')));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
