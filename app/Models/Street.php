<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Street
 * @property integer id
 * @property string name
 * @property integer city_id
 * @package App\Models
 */
class Street extends Model
{
    protected $table = 'streets';
}
