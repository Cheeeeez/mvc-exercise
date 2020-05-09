<?php
function checkEmail($str)
{
    $regex = '/^[A-Za-z0-9]+[A-Za-z0-9.]*@[A-Za-z0-9]+(\.[A-Za-z0-9]+)$/';
    if (preg_match($regex, $str)) {
        return true;
    } else {
        return false;
    }
}

function checkPassword($str)
{
    $regex = '/^\S*(?=\S{8,})(?=\S*[A-Z])(?=\S*[0-9])(?=\S*[@!%\^\-\$])\S*$/';

    if (preg_match($regex, $str)) {
        return true;
    } else {
        return false;
    }
}
