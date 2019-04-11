<?php
namespace app\production\model;

use think\Model;
class Production extends Model
{
    protected $field = [
        'id' => 'int',
        'orderId','workstage1','workstage2',
        'workstage3','date','status',
    ];
}