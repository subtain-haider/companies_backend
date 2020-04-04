<?php

namespace LaravelEnso\Companies\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LaravelEnso\Companies\App\Enums\CompanyStatuses;

class ValidateCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'mandatary' => 'nullable|exists:people,id',
            'code' => ['required', 'string', $this->unique('code')],
            'name' => ['required', 'string', $this->unique('name')],
            'status' => 'required|numeric|in:'.CompanyStatuses::keys()->implode(','),
            'email' => 'email|nullable',
            'phone' => 'nullable',
            'is_tenant' => 'required|boolean',
        ];
    }

    public function withValidator($validator)
    {
        if ($this->filled('mandatary') && $this->mandataryIsNotAssociated()) {
            $validator->after(fn ($validator) => $validator->errors()
                ->add('mandatary', __('The selected person is not associated to this company'))
            );
        }
    }

    protected function mandataryIsNotAssociated()
    {
        return ! $this->route('company')->people()
            ->pluck('id')->contains($this->get('mandatary'));
    }

    protected function unique(string $attribute)
    {
        return Rule::unique('companies', $attribute)
            ->ignore(optional($this->route('company'))->id);
    }
}
