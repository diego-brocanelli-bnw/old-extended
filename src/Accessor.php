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
    public function oldCheck($key, $input_value = 'no', $stored_value = null)
    {
        $old = old($key, false);

        // Usuário já checou a opção
        if ($old !== false && $old == $input_value) {

            $this->setOrigin(self::ORIGIN_FORM, $old);
            return 'checked';
        }
        // Usuário não selecionou ainda, compara com banco de dados
        elseif($old === false && $stored_value == $input_value) {

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
    public function oldRadio($key, $input_value = null, $stored_value = null)
    {
        $old = old($key, false);

        // Usuário já setou a opção
        if ($old !== false && $old == $input_value) {

            $this->setOrigin(self::ORIGIN_FORM, $old);
            return 'checked';
        }
        // Usuário não selecionou ainda, compara com banco de dados
        elseif($old === false  && !empty($stored_value) && $stored_value == $input_value) {
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
    public function oldOption($key, $option_value = null, $stored_value = null)
    {
        $old = old($key, false);

        // Usuário já selecionou uma opção
        if ($old !== false && $old == $option_value) {

            $this->setOrigin(self::ORIGIN_FORM, $old);
            return 'selected';
        }
        // Usuário não selecionou ainda, compara com banco de dados
        elseif($old === false && !empty($stored_value) && $stored_value == $option_value) {

            $this->setOrigin(self::ORIGIN_STORE, $stored_value);
            return 'selected';
        }
        else {

            $this->setOrigin(self::ORIGIN_DEFAULT);
            return '';
        }
    }

    /**
     * Helper semelhante ao old() original do Laravel,
     * porém, para ser usado com datas
     *
     * @param string $key          O nome do campo de formulário
     * @param mixed  $stored_value O valor armazenado em banco de dados
     * @param string $store_format    O formato recebida Ex: d/m/Y
     * @param string $show_format   O formato a ser exibido Ex: Y-m-d
     */
    public function oldDate($key, $stored_value = null, $stored_format = 'Y-m-d', $show_format = 'd/m/Y')
    {
        $old = old($key, false);

        // Usuário já preencheu uma data
        if ($old !== false) {

            $this->setOrigin(self::ORIGIN_FORM, $old);
            $value = $old;
        }
        // Usuário não digitou ainda, compara com banco de dados
        else {

            $this->setOrigin(self::ORIGIN_STORE, $stored_value);
            $value = $stored_value;
        }
        
        $date = \DateTime::createFromFormat($stored_format, $value);
        if ($date === false) {
            return '';
        }

        // Guarda as informações para identificar na próxima requisição
        $old_extended_date = (\Cache::has('old_extended_date'))
            ? \Cache::get('old_extended_date') : [];

        $old_extended_date[$key] = "{$show_format}:::{$stored_format}";
        \Cache::put('old_extended_date', $old_extended_date, now()->addMinutes(30));


        header('Cache-Control: max-age=0, no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: Fri, 20 Mar 2014 00:00:00 GMT');

        return $date->format($show_format);
    }

    /**
     * Helper semelhante ao old() original do Laravel,
     * porém, para ser usado com datas
     *
     * @param string $key          O nome do campo de formulário
     * @param mixed  $stored_value O valor armazenado em banco de dados
     * @param string $store_format    O formato recebida Ex: d/m/Y H:i:s
     * @param string $show_format   O formato a ser exibido Ex: Y-m-d H:i:s
     */
    public function oldDateTime($key, $stored_value = null, $stored_format = 'Y-m-d H:i:s', $show_format = 'd/m/Y H:i:s')
    {
        return $this->oldDate($key, $stored_value, $stored_format, $show_format);
    }
}
