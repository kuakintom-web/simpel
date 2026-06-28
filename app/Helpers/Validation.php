<?php

namespace App\Helpers;

class Validation
{
    private static $errors = [];
    
    public static function required($field, $value)
    {
        if (empty($value)) {
            self::$errors[$field] = "$field tidak boleh kosong";
            return false;
        }
        return true;
    }
    
    public static function email($field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            self::$errors[$field] = "$field harus berupa email yang valid";
            return false;
        }
        return true;
    }
    
    public static function minLength($field, $value, $min)
    {
        if (strlen($value) < $min) {
            self::$errors[$field] = "$field minimal $min karakter";
            return false;
        }
        return true;
    }
    
    public static function maxLength($field, $value, $max)
    {
        if (strlen($value) > $max) {
            self::$errors[$field] = "$field maksimal $max karakter";
            return false;
        }
        return true;
    }
    
    public static function numeric($field, $value)
    {
        if (!is_numeric($value)) {
            self::$errors[$field] = "$field harus berupa angka";
            return false;
        }
        return true;
    }
    
    public static function getErrors()
    {
        return self::$errors;
    }
    
    public static function hasErrors()
    {
        return !empty(self::$errors);
    }
    
    public static function clearErrors()
    {
        self::$errors = [];
    }
}
