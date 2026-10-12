<?php
namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'first_name'   => ['required', 'string', 'max:255'],
            'last_name'    => ['required', 'string', 'max:255'],
            // 'email'        => [
            //     'required',
            //     'string',
            //     'lowercase',
            //     'email',
            //     'max:255',
            //     Rule::unique(User::class)->ignore($this->user()->id),
            // ],
            'bio'          => ['nullable', 'string', 'max:255'],
            'gender'       => [
                'nullable',
                'string',
                Rule::in([
                    'Man',
                    'Woman',
                    'Non-binary',
                    'Transgender',
                    'Trans Man',
                    'Trans Woman',
                    'Cisgender Man',
                    'Cisgender Woman',
                    'Genderfluid',
                    'Genderqueer',
                    'Agender',
                    'Bigender',
                    'Demigender',
                    'Demiboy',
                    'Demigirl',
                    'Pangender',
                    'Polygender',
                    'Multigender',
                    'Androgynous',
                    'Neutrois',
                    'Maverique',
                    'Xenogender',
                    'Gender Non-conforming',
                    'Gender-expansive',
                    'Transmasculine',
                    'Transfeminine',
                    'Intergender',
                    'Intersex',
                    'Two-Spirit',
                    'Third Gender',
                    'Questioning My Gender',
                    'Another Gender Identity',
                    'Prefer not to say',
                    'Other',
                    'Questioning',
                ]),
            ],
            'relationship' => ['nullable', 'string'],
            'image'        => ['nullable', 'image', 'max:2048'],
            'price'        => ['nullable', 'numeric'],
            'pronouns'     => ['nullable'],
            'address'      => ['nullable'],
            'password'     => ['nullable', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'email'        => ['nullable', 'email', 'max:255', Rule::unique(User::class, 'email')->ignore($this->user()->id),
            ],
        ];
    }
}
