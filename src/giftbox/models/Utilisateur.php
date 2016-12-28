<?php

namespace giftbox\models;

class Utilisateur extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'id';
    public $timestamps = false;
}