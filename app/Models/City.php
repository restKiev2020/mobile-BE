<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 * @property integer id
 * @property string name
 * @property integer region_id
 * @package App\Models
 */
class City extends Model
{
    protected $table = 'cities';
}
