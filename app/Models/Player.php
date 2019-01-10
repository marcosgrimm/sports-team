<?php
/**
 * Created by PhpStorm.
 * User: marcos
 * Date: 10/01/19
 * Time: 15:33
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Player extends Model
{

    private $protected = [ 'first_name','last_name'];
}