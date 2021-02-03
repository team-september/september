<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MultipleProfileUpdateRequest extends FormRequest
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
        $formRequests = [
            UserUpdateRequest::class,
            ProfileUpdateRequest::class,
            UrlUpdateRequest::class,
            SkillUpdateRequest::class,
            PurposeUpdateRequest::class,
        ];

        $rules = [];

        foreach ($formRequests as $source) {
            $rules = array_merge(
                $rules,
                (new $source)->rules()
            );
        }

        return $rules;
    }
}
