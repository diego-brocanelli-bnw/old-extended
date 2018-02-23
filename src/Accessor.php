<?php 

namespace OldExtended;

/**
 * ...
 */
class Accessor
{
    const ORIGIN_FORM    = 'form';
    
    const ORIGIN_STORE   = 'store';
    
    const ORIGIN_DEFAULT = 'default';

    private $debug_origin = null;

    /**
     * Carrega e inclui os helpers do pacote
     * 
     * @return void
     */
    public function loadHelpers()
    {
        include('helpers.php');
    }

    public function debugOrigin()
    {
        return $this->debug_origin;
    }

    private function setOrigin($origin = self::ORIGIN_DEFAULT, $value = '')
    {
        return $this->debug_origin = "$origin" . (!empty($value) ? '::'.$value : '');
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
    //public function oldCheck($key = null, $default = null, $active_value = 'on')
    public function oldCheck($key = null, $input_value = 'no', $stored_value = null)
    {
        $old = old($key, false);

        // Usuário já checou a opção
        if ($old != false && $old == $input_value) {

            $this->setOrigin(self::ORIGIN_FORM, $old);
            return 'checked';
        }
        // Usuário na selecionou ainda, compara com banco de dados
        elseif($old == false && $stored_value == $input_value) {

            $this->setOrigin(self::ORIGIN_STORE, $stored_value);
            return 'checked';
        }
        else {
            $this->setOrigin(self::ORIGIN_DEFAULT);
            return '';
        }
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
    public function oldRadio($key = null, $input_value = null, $stored_value = null)
    {
        $old = old($key, false);

        // Usuário já setou a opção
        if ($old != false && $old == $input_value) {

            $this->setOrigin(self::ORIGIN_FORM, $old);
            return 'checked';
        }
        // Usuário não selecionou ainda, compara com banco de dados
        elseif($old == false  && !empty($stored_value) && $stored_value == $input_value) {
            $this->setOrigin(self::ORIGIN_STORE, $stored_value);
            return 'checked';
        }
        else {

            $this->setOrigin(self::ORIGIN_DEFAULT);
            return '';
        }
    }

    /**
     * Helper semelhante ao old() original do Laravel,
     * porém, para ser usado em options de inputs do tipo select
     *
     * @see https://github.com/rpdesignerfly/laravel-old-extended/blob/master/docs/02-Usage.md
     * 
     * @param string $key          O nome do campo de formulário
     * @param mixed  $option_value O valor da tag option
     * @param mixed  $stored_value O valor armazenado em banco de dados
     */
    public function oldOption($key = null, $option_value = null, $stored_value = null)
    {
        $old = old($key, false);

        // Usuário já selecionou uma opção
        if ($old != false && $old == $option_value) {

            $this->setOrigin(self::ORIGIN_FORM, $old);
            return 'selected';
        }
        // Usuário na selecionou ainda, compara com banco de dados
        elseif($old == false && !empty($stored_value) && $stored_value == $option_value) {

            $this->setOrigin(self::ORIGIN_STORE, $stored_value);
            return 'selected';
        }
        else {

            $this->setOrigin(self::ORIGIN_DEFAULT);
            return '';
        }
    }


}
