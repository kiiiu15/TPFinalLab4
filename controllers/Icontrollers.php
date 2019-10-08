<?php
namespace controllers;

interface Icontrollers {
    function add ($element);
    function delete ($element);
    function getAll();
    function edit(); 
}

?>