<?php
/**
 * @see       https://github.com/rpdesignerfly/old-extended
 * @copyright Copyright (c) 2018 Ricardo Pereira Dias (https://rpdesignerfly.github.io)
 * @license   https://github.com/rpdesignerfly/old-extended/blob/master/license.md
 */

declare(strict_types=1);

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

    /**
     * Helper semelhante ao old() original do Laravel,
     * porém, para ser usado em inputs do tipo checkbox
     *
     * @see https://github.com/rpdesignerfly/laravel-old-extended/blob/master/docs/02-Usage.md
     *
     * @param string $key          O nome do campo de formulário
     * @param mixed  $input_value  O valor do input checkbox
     * @param mixed  $stored_value O valor armazenado em banco de dados
     */
    public function oldCheck($key, $input_value = null, $stored_value = null)
    {
        return \OldExtended::oldCheck($key, $input_value, $stored_value);
    }

    /**
     * Helper semelhante ao old() original do Laravel,
     * porém, para ser usado em inputs do tipo radio
     *
     * @see https://github.com/rpdesignerfly/laravel-old-extended/blob/master/docs/02-Usage.md
     *
     * @param string $key          O nome do campo de formulário
     * @param mixed  $input_value  O valor do input radio
     * @param mixed  $stored_value O valor armazenado em banco de dados
     */
    public function oldRadio($key, $input_value = null, $stored_value = null)
    {
        return \OldExtended::oldRadio($key, $input_value, $stored_value);
    }

    /**
     * Helper semelhante ao old() original do Laravel,
     * porém, para ser usado em options de inputs do tipo select
     *
     * @param string $key          O nome do campo de formulário
     * @param mixed  $option_value O valor da tag option
     * @param mixed  $stored_value O valor armazenado em banco de dados
     */
    function oldOption($key, $option_value = null, $stored_value = null)
    {
        return \OldExtended::oldOption($key, $option_value, $stored_value);
    }

    /**
     * Helper semelhante ao old() original do Laravel,
     * porém, para ser usado com datas
     *
     * @param string $key           O nome do campo de formulário
     * @param mixed  $stored_value  O valor armazenado em banco de dados
     * @param string $stored_format O formato recebida Ex: d/m/Y
     * @param string $show_format   O formato a ser exibido Ex: Y-m-d
     */
    public function oldDate($key, $stored_value = null, $stored_format = 'Y-m-d', $show_format = 'd/m/Y')
    {
        return \OldExtended::oldDate($key, $stored_value, $stored_format, $show_format);
    }

    /**
     * Helper semelhante ao old() original do Laravel,
     * porém, para ser usado com datas
     *
     * @see https://github.com/rpdesignerfly/laravel-old-extended/blob/master/docs/02-Usage.md
     *
     * @param string $key           O nome do campo de formulário
     * @param mixed  $stored_value  O valor armazenado em banco de dados
     * @param string $stored_format O formato recebida Ex: d/m/Y H:i:s
     * @param string $show_format   O formato a ser exibido Ex: Y-m-d H:i:s
     */
    public function oldDatetime($key, $stored_value = null, $stored_format = 'Y-m-d H:i:s', $show_format = 'd/m/Y H:i:s')
    {
        return \OldExtended::oldDateTime($key, $stored_value, $stored_format, $show_format);
    }

    /**
     * Transforma uma data de um formato para outro
     *
     * @param string $date_value     O valor da data
     * @param string $format_origin  O formato original do valor Ex: d/m/Y
     * @param string $format_destiny O formato transformado Ex: Y-m-d
     */
    public function dateTransform($date_value, $format_origin = 'd/m/Y H:i:s', $format_destiny = 'Y-m-d H:i:s')
    {
        return \OldExtended::dateTransform($date_value, $format_origin, $format_destiny);
    }
}
