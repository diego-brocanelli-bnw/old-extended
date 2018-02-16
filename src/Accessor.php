<?php 

namespace OldExtended;

/**
 * ...
 */
class Accessor
{
    public function oldCheck($key = null, $default = null, $active_value = 'on')
    {
        return (old($key, null) == $active_value || $default == $active_value)
            ? 'checked' : '';
    }

    public function oldOption($key = null, $default = null, $active_value = null)
    {
        if ($active_value === null && $default === 1) {
             return 'selected';
        }
        
        return (old($key, 'nullnull') == $active_value || $default == $active_value)
            ? 'selected' : '';
    }
}
