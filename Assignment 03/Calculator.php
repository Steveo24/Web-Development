<?php
class Calculator {
    
    public function calc($param, $arg1 = [], $arg2 = []) {

        if($param == "/" && $arg2 == 0)
        {
            return "Cannot divide by zero</br>";
        }

        if($arg1 == null || $arg2 == null) 
        {
            return "You must enter a string and two numbers</br>";
        }

        if($param == "+")
        {
            return "The sum of the numbers is " . ($arg1 + $arg2) . "</br>";
        }

        if($param == "*")
        {
            return "The product of the numbers is " . ($arg1 * $arg2) . "</br>";
        }

        if($param == "-")
        {
            return "The difference of the numbers is " . ($arg1 - $arg2) . "</br>";
        }

        if($param == "/")
        {
            return "The division of the numbers is " . ($arg1 / $arg2) . "</br>";
        }
    }
}