<?php

namespace App\Http\Requests;

use App\Models\ProfileData;
use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', ProfileData::where('user_id', $this->id)->first());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'max:50',
            'status' => 'max:500',
            'newProfilePic' => 'file|mimes:jpeg,png,jpg,gif|max:20480|dimensions:min_width=150,min_height=150',
            'newProfilePicThumbnail' => 'file|mimes:png|dimensions:width=150,height=150'
        ];
    }
}
