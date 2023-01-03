<?php

function format(string $pattern,string $subject,string $replaced = ''){
    return preg_replace($pattern, $replaced, $subject);
}