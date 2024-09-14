<?php
class HomeController
{
    public function index()
    {
        header("Location: /catalog");
        exit();
    }
}
