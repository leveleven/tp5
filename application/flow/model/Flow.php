<?php
namespace app\flow\model;
use think\Model;

class Flow extends Model
{
    protected $name = 'main';
    protected $field = [
        'id' => 'int',
        'orderId','production','customer',
        'material','picNumber','quantity',
        'startDate','finished','success',
        'delivery','endDate','status',
    ];

    public function scopeOrderId($query, $id)
    {
        $query->where(orderId, $id);
    }
}