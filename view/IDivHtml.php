<?php 

interface IDivHtml
{
    public function response();
    public function setMessage(string $message);
    public function setUser(User $user = null) : void;
}