<?php
namespace app\quality\model;

use think\Model;

class Quality extends Model
{
    protected $field = [
        'id' => 'int',
        'orderId','quantity','qualified',
        'pending','unqualified','status',
    ];
}