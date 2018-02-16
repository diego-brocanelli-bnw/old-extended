<?php

if (!function_exists('old_check')) {

    /**
     * Helper semelhante ao old() original do Laravel,
     * porém, para ser usado em inputs do tipo checkbox
     *
     * @see https://github.com/rpdesignerfly/laravel-old-extended/blob/master/docs/02-Usage.md
     * 
     * @param string $key          A chave do parâmetro enviado pela requisição
     * @param mixed  $default      O parâmetro padrão, caso não exista um valor 'old'
     * @param mixed  $active_value A propriedade checked é devolvida se $active_value == $default
     */
    function old_check($key = null, $default = null, $active_value = 'on')
    {
        return OldExtended::oldCheck($key, $default, $active_value);
    }

}

if (!function_exists('old_option')) {

    /**
     * Helper semelhante ao old() original do Laravel,
     * porém, para ser usado em options de inputs do tipo select
     *
     * @see https://github.com/rpdesignerfly/laravel-old-extended/blob/master/docs/02-Usage.md
     * 
     * @param string $key          A chave do parâmetro enviado pela requisição
     * @param mixed  $default      O parâmetro padrão, caso não exista um valor 'old'
     * @param mixed  $active_value A propriedade selected é devolvida se $active_value == $default
     */
    function old_option($key = null, $default = null, $active_value = null)
    {
        return OldExtended::oldOption($key, $default, $active_value);
    }
}
