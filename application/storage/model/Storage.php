<?php
namespace app\storage\model;
use think\Model;

class Storage extends Model
{
    protected $field = [
        'id' => 'int',
        'orderId','material','quantity',
        'stockDate','deliveryDate','status',
    ];
}