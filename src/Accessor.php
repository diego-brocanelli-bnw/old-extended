<?php 

namespace OldExtended;

/**
 * ...
 */
class Accessor
{
    const ORIGIN_FORM     = 'form';
    
    const ORIGIN_STORE    = 'store';
    
    const ORIGIN_DEFAULT  = 'default';
    
    private $debug_origin = null;
    
    private $initialized  = false;

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

    private function initialize()
    {
        if ($this->initialized == false) {
            header('Cache-Control: max-age=0, no-cache, no-store, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: Fri, 20 Mar 2014 00:00:00 GMT');
        }

        $this->initialized = true;
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
    public function oldCheck($key, $input_value = 'no', $stored_value = null)
    {
        $this->initialize();

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
        $this->initialize();

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
        $this->initialize();

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
     * Transforma uma data de um formato para outro
     *
     * @param string $date_value     O valor da data
     * @param string $format_origin  O formato original do valor Ex: d/m/Y
     * @param string $format_destiny O formato transformado Ex: Y-m-d
     */
    public function dateTransform($date_value, $format_origin = 'd/m/Y H:i:s', $format_destiny = 'Y-m-d H:i:s')
    {
        $date = \DateTime::createFromFormat($format_origin, $date_value);
        return $date !== false ? $date->format($format_destiny) : '';
    }

    /**
     * Helper semelhante ao old() original do Laravel,
     * porém, para ser usado com datas
     *
     * @param string $key          O nome do campo de formulário
     * @param mixed  $stored_value O valor armazenado em banco de dados
     * @param string $store_format O formato recebida Ex: d/m/Y
     * @param string $show_format  O formato a ser exibido Ex: Y-m-d
     */
    public function oldDate($key, $stored_value = null, $stored_format = 'Y-m-d', $show_format = 'd/m/Y')
    {
        $this->initialize();

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
        
        $date = $this->dateTransform($value, $stored_format, $show_format);
        if (empty($date)) {
            return '';
        }

         // Guarda as informações para identificar na próxima requisição
        $old_extended_token    = 'old_extended_date_' . csrf_token();
        $old_extended_date = session()->has($old_extended_token)
            ? session($old_extended_token) : [];
        $old_extended_date[$key] = "{$show_format}:::{$stored_format}";
        session()->put($old_extended_token, $old_extended_date);

        return $date;
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
