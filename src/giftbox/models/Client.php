<?php
/**
 * Created by PhpStorm.
 * User: Teddy
 * Date: 29/12/2016
 * Time: 14:42
 */

namespace giftbox\models;


class Client extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'client';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function coffrets(){
        return $this->hasMany('\giftbox\models\Coffret', 'id_cli');
    }
}