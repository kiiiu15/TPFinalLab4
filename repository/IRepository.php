<?php
namespace Repository;

interface IRepository {

    function Add($value);
    function GetAll();
    function Delete($value);

}
?>