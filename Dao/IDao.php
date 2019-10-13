<?php
namespace Dao;          
interface IDao 
{
    function Add($param);
    function GetAll();
    function Remove($id);
}

?>