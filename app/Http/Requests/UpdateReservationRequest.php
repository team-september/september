<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
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
            'reservation-ids' => ['array', 'min:1'],
            'reservation-ids.*' => ['exists:reservations,id'],
            'user-ids.*' => ['exists:users,id'],
            'comment' => ['nullable', 'array'],
            'comment.*' => ['nullable', 'string'],
            'status' => ['in:2,3'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // nullは除外
        $this->merge([
            'reservation-ids' => array_filter($this->input('reservation-ids'), function ($reservationId) {
                return isset($reservationId);
            }),
            'user-ids' => array_filter($this->input('user-ids'), function ($userId) {
                return isset($userId);
            }),
        ]);
    }
}
