<?php

//use LaravelFormHelpers\FormHelpers;

### olden

### fill_post

### fill_get

### fill_password


if (!function_exists('olden')) {

    function olden()
    {
        return FormHelper::olden();
    }
}

if (!function_exists('olden_check')) {

    function olden_check()
    {
        return FormHelper::oldenCheck();
    }
}

if (!function_exists('olden_radio')) {

    function olden_radio()
    {
        return FormHelper::oldenRadio();
    }
}

if (!function_exists('fill_post')) {

    function fill_post()
    {
        return FormHelper::fillPost();
    }
}

if (!function_exists('fill_get')) {

    function fill_get()
    {
        return FormHelper::fillGet();
    }
}

if (!function_exists('fill_password')) {

    function fill_password()
    {
        return FormHelper::fillPassword();
    }
}