<?php
/**
 * Created by PhpStorm.
 * User: Teddy
 * Date: 28/12/2016
 * Time: 12:33
 */

namespace giftbox\models;


class Coffret extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'coffret';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function prestations(){
        return $this->hasMany('\giftbox\models\Contient', 'id_coffret');
    }
}