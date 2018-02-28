<?php

namespace OldExtended\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExtendedRequest extends FormRequest
{
    private function mudateDates()
    {
        $old_extended_token = 'old_extended_date_' . csrf_token();
        $request = $this;

        // Apenas os metodos de gravação possuem tratamento
        $is_save = $request->isMethod('post') || $request->isMethod('put') || $request->isMethod('delete');

        // Se existir uma chamada para tratar das datas
        if (session()->has($old_extended_token) && $is_save == true) {

            $old_extended_date = session($old_extended_token);

            // Datas que precisam de tratamento
            foreach ($old_extended_date as $key => $mutation) {

                if ($request->offsetExists($key)){

                    $value = $request->offsetGet($key);
                    $mutate = explode(':::', $mutation);

                    $value = \OldExtended::dateTransform($value, $mutate[0], $mutate[1]);
                    $request->offsetSet($key, $value);
                }
            }

            session()->forget($old_extended_token);
        }
    }

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
        $this->mudateDates();

        return [
            //
        ];
    }
}
