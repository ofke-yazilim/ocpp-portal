<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Mongo extends Model
{
    //$mongo = (new \App\Models\Mongo)->setCollectionName('logs')->where('price', '>', 100)->get();
    protected $connection = 'mongodb';
    protected $collection = 'logs';
    protected $table      = 'main';
    protected $guarded    = [];
    public $incrementing  = false;
    public $timestamps    = false;


    public function setCollectionName($collectionName)
    {
        $this->table = $collectionName;
        return $this;
    }
}



