<?php 

interface IDivHtml
{
    public function response(bool $isLoggedIn);
    public function setMessage(string $message);
}