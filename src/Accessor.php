<?php 

namespace OldExtended;

/**
 * ...
 */
class Accessor
{
    /**
     * Carrega e inclui os helpers do pacote
     * 
     * @return void
     */
    public function loadHelpers()
    {
        include('helpers.php');
    }

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
    public function oldCheck($key = null, $default = null, $active_value = 'on')
    {
        return (old($key, null) == $active_value || $default == $active_value)
            ? 'checked' : '';
    }

    /**
     * Helper semelhante ao old() original do Laravel,
     * porém, para ser usado em inputs do tipo checkbox
     *
     * @see https://github.com/rpdesignerfly/laravel-old-extended/blob/master/docs/02-Usage.md
     * 
     * @param string $key             A chave do parâmetro enviado pela requisição
     * @param mixed  $value           O valor deste radiobox
     * @param mixed  $default_checked Será checado por padrão se não existir um radio setado
     */
    public function oldRadio($key = null, $default = null, $default_checked = false)
    {
        return (old($key, null) == $default || (old($key, null)==null && $default_checked == true))
            ? 'checked' : '';
    }

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
    public function oldOption($key = null, $default = null, $active_value = null)
    {
        if ($active_value === null && $default === 1) {
             return 'selected';
        }
        
        return (old($key, 'nullnull') == $active_value || $default == $active_value)
            ? 'selected' : '';
    }
}
