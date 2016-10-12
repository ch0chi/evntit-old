<?php
//sanitizes data so we can output data
//user has ability to update profile information and will protect against output

function escape($string){
    return htmlentities($string,ENT_QUOTES,'UTF-8');//escape string that is passed in. ent_quotes skips single and double quotes
}