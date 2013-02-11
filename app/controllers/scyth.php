<?php

class Controller_scyth extends Controller
{
    public function index()
    {
        $this->app->get('view')->show('layout','scyth');
    }
}