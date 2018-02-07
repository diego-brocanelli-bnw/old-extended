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
}
