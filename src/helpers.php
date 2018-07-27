<?php
/**
 * @see       https://github.com/rpdesignerfly/old-extended
 * @copyright Copyright (c) 2018 Ricardo Pereira Dias (https://rpdesignerfly.github.io)
 * @license   https://github.com/rpdesignerfly/old-extended/blob/master/license.md
 */

declare(strict_types=1);

if (!function_exists('old_debug_origin')) {

    function old_debug_origin()
    {
        return OldExtended::debugOrigin();
    }
}

if (!function_exists('old_check')) {

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
    function old_check($key, $input_value = null, $stored_value = null)
    {
        return OldExtended::oldCheck($key, $input_value, $stored_value);
    }
}

if (!function_exists('old_radio')) {

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
    function old_radio($key, $input_value = null, $stored_value = null)
    {
        return OldExtended::oldRadio($key, $input_value, $stored_value);
    }
}

if (!function_exists('old_option')) {

    /**
     * Helper semelhante ao old() original do Laravel,
     * porém, para ser usado em options de inputs do tipo select
     *
     * @param string $key          O nome do campo de formulário
     * @param mixed  $option_value O valor da tag option
     * @param mixed  $stored_value O valor armazenado em banco de dados
     */
    function old_option($key, $option_value = null, $stored_value = null)
    {
        return OldExtended::oldOption($key, $option_value, $stored_value);
    }
}

if (!function_exists('old_date')) {

    /**
     * Helper semelhante ao old() original do Laravel,
     * porém, para ser usado com datas
     *
     * @param string $key           O nome do campo de formulário
     * @param mixed  $stored_value  O valor armazenado em banco de dados
     * @param string $stored_format O formato recebida Ex: d/m/Y
     * @param string $show_format   O formato a ser exibido Ex: Y-m-d
     */
    function old_date($key, $stored_value = null, $stored_format = 'Y-m-d', $show_format = 'd/m/Y')
    {
        return OldExtended::oldDate($key, $stored_value, $stored_format, $show_format);
    }
}

if (!function_exists('old_datetime')) {

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
    function old_datetime($key, $stored_value = null, $stored_format = 'Y-m-d H:i:s', $show_format = 'd/m/Y H:i:s')
    {
        return OldExtended::oldDateTime($key, $stored_value, $stored_format, $show_format);
    }
}

if (!function_exists('date_transform')) {

    /**
     * Transforma uma data de um formato para outro
     *
     * @param string $date_value     O valor da data
     * @param string $format_origin  O formato original do valor Ex: d/m/Y
     * @param string $format_destiny O formato transformado Ex: Y-m-d
     */
    function date_transform($date_value, $format_origin = 'd/m/Y H:i:s', $format_destiny = 'Y-m-d H:i:s')
    {
        return OldExtended::dateTransform($date_value, $format_origin, $format_destiny);
    }
}
