<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class EditPostRequest extends FormRequest
{
    protected $post;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->post = Post::find($this->route('post'));
        return $this->user()->can('update', $this->post);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        if(!$this->post->repostable_id) {
            return [
                'text' => 'required|string'
            ];
        };
        return [
            'text' => 'string'
        ]; 
    }
}
