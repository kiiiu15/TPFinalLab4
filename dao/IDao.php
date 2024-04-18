<?php
namespace Dao;          
interface IDao 
{
    function Add($param);   //c
    function GetAll();      //r
    function Modify($param);//u
    function Delete($param);//d

}

?>