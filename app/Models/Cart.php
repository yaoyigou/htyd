<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'rec_id';
    public $timestamps = false;

    public function goods()
    {
        return $this->belongsTo(Goods::class, 'goods_id');
    }

    public function get_cart_goods($user, $str = '', $type = 0)
    {
        $query = self::with(
            [
                'goods' => function ($query) {
                    $query->with('goods_attr', 'member_price');
                }
            ]
        )->where('user_id', $user->user_id)->orderBy('rec_id', 'desc');
        if (!empty($str)) {
            $query->whereIn('rec_id', $str);
        }
        $query->select('goods_id', 'rec_id', 'goods_number', 'goods_price');
        if ($type == 1) {
            $cart        = $query->first();
            $cart->goods = $cart->goods->attr($cart->goods, $user);
            return $cart;
        } else {
            $cart = $query->get();
        }
        $delId = [];
        foreach ($cart as $k => $v) {
            if ($v->goods) {
                $v->goods = $v->goods->attr($v->goods, $user);
            } else {
                $delId[] = $v->rec_id;
                unset($cart[$k]);
            }
        }
        if (!empty($delId)) {
            self::destroy($delId);
        }
        return $cart;
    }

    public static function updateBatch($tableName = "", $multipleData = array())
    {

        if ($tableName && !empty($multipleData)) {

            // column or fields to update
            $updateColumn    = array_keys($multipleData[0]);
            $referenceColumn = $updateColumn[0]; //e.g id
            unset($updateColumn[0]);
            $whereIn = "";

            $q = "UPDATE " . $tableName . " SET ";
            foreach ($updateColumn as $uColumn) {
                $q .= $uColumn . " = CASE ";

                foreach ($multipleData as $data) {
                    $q .= "WHEN " . $referenceColumn . " = " . $data[$referenceColumn] . " THEN '" . $data[$uColumn] . "' ";
                }
                $q .= "ELSE " . $uColumn . " END, ";
            }
            foreach ($multipleData as $data) {
                $whereIn .= "'" . $data[$referenceColumn] . "', ";
            }
            $q = rtrim($q, ", ") . " WHERE " . $referenceColumn . " IN (" . rtrim($whereIn, ', ') . ")";

            // Update
            return DB::update(DB::raw($q));

        } else {
            return false;
        }
    }
}
