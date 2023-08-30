<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('array_group_by')) {
    function array_group_by($arrays,$by_property='id'){

        // not an array, fail
        if (!is_array($arrays)) return false;

        // if empty, return
        if (empty($arrays)) return $arrays;

        $are_items_objects = is_object(reset($arrays));

        $new_array = [];
        foreach ($arrays as $item) {

            if ($are_items_objects) {
                // if $by_property is not set, fail
                if (!isset($item->$by_property)) return false;
                $by_property_value = $item->$by_property;
            } else {
                // if $by_property is not set, fail
                if (!isset($item[$by_property])) return false;
                $by_property_value = $item[$by_property];
            }

            $new_array[ $by_property_value ][] = $item;
        }

        return $new_array;
    }
}

if (!function_exists('array_reindex_by')) {
    function array_reindex_by($array,$by_property='id',$remove_by_property=false, $cast_to=null)
    {
        $new_array = [];
        if (isset($array[0]) && is_array($array[0])) {
            foreach ($array as &$item) {
                $index = $item[$by_property];
                if ($remove_by_property) {
                    unset($item[$by_property]);
                }
                if ($cast_to==='object') {
                    $item = (object) $item;
                }
                $new_array[$index] = $item;
            }
        } else {
            foreach ($array as &$item) {
                $index = $item->$by_property;
                if ($remove_by_property) {
                    unset($item->$by_property);
                }
                if ($cast_to==='array') {
                    $item = (array) $item;
                }
                $new_array[$index] = $item;
            }
            unset($item);
        }

        return $new_array;
    }
}

if (!function_exists('random_strings')) {
    function random_strings($length_of_string){
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        // Shuffle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}

if (!function_exists('startsWith')) {
    function startsWith( $haystack, $needle ) {
        $length = strlen( $needle );
        return substr( $haystack, 0, $length ) === $needle;
    }
}

if (!function_exists('endsWith')) {
    function endsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    if( !$length ) {
        return true;
    }
    return substr( $haystack, -$length ) === $needle;
    }
}

if (!function_exists('is_admin')) {
    function is_admin()
    {
        $CI =& get_instance();
        return $CI->session->userdata('user_type') == '1';
    }
}

if (!function_exists('is_employee')) {
    function is_employee()
    {
        $CI =& get_instance();
        return $CI->session->userdata('user_type') == '2';
    }
}

if (!function_exists('is_user')) {
    function is_user()
    {
        $CI =& get_instance();
        return !in_array($CI->session->userdata('user_type'), ['1','2']);
    }
}

?>