<?php

function getString(?string $string = null): string|bool
{
    return $string ?? false;
}


var_dump(getString());
