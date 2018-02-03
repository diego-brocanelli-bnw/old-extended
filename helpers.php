<?php

### olden

### fill_post

### fill_get

### fill_password


if (!function_exists('olden')) {

    function olden()
    {
        return \FormHelpers::olden();
    }
}

if (!function_exists('olden_check')) {

    function olden_check()
    {
        return \FormHelpers::oldenCheck();
    }
}

if (!function_exists('olden_radio')) {

    function olden_radio()
    {
        return \FormHelpers::oldenRadio();
    }
}

if (!function_exists('fill_post')) {

    function fill_post()
    {
        return \FormHelpers::fillPost();
    }
}

if (!function_exists('fill_get')) {

    function fill_get()
    {
        return \FormHelpers::fillGet();
    }
}

if (!function_exists('fill_password')) {

    function fill_password()
    {
        return \FormHelpers::fillPassword();
    }
}