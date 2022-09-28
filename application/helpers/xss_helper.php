<?php

function xss_input($input)
{
    return htmlspecialchars($input);
}

function xss($data)
{
    return htmlentities($data);
}