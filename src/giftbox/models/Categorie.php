<?php
/**
 * Created by PhpStorm.
 * User: valette15u
 * Date: 05/12/2016
 * Time: 10:57
 */

namespace giftbox\models;


class Categorie extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'categorie';
    protected $primaryKey = 'id';
    public $timestamps = false;
}