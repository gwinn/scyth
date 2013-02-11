<?php

class Loader
{
    private function load($path,$f)
    {
        $file = APP_PATH . $path . DIR_SEP . strtolower($f) . '.php';
        
        if(!file_exists($file))
        {
            throw new Exception('Can not open ' . $file);
        }

        include_once($file);
    }

    public function vendor($vendor)
    {
        $this->load('vendor', $vendor);
        return new $vendor;
    }

    public function model($model)
    {
        $this->load('model', $model);
        return new $model;
    }
}
