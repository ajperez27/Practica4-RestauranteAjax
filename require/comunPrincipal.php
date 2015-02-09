<?php

function autoload($clase) {
    require './clases/' . $clase . '.php';
}

spl_autoload_register('autoload');
