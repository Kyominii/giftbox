<?php
/**
 * Created by PhpStorm.
 * User: Teddy
 * Date: 28/12/2016
 * Time: 12:33
 */

namespace giftbox\models;


class Contient extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'contient';
    protected $primaryKey = 'id';
    public $timestamps = false;
}