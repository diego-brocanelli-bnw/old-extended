<?php

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
    function old_check($key = null, $input_value = null, $stored_value = null)
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
    function old_radio($key = null, $input_value = null, $stored_value = null)
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
    function old_option($key = null, $option_value = null, $stored_value = null)
    {
        return OldExtended::oldOption($key, $option_value, $stored_value);
    }
}
