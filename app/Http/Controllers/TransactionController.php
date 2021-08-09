<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailCart;
use App\Models\Cart;
use App\Helper\ResponseHelper as JsonHelper;
use Carbon, Validator;

class TransactionController extends Controller
{
    public function addToCart (Request $request) {
        $res = new JsonHelper;

        $validator = Validator::make($request->all(), [
            'qty' => 'required',
        ]);
        if($validator->fails()){
            return $res->responseGet(false, 400, '', $validator->errors());
        }
        $cartCheck = Cart::where('active', 1)->where('id_user', auth()->user()->id)->get();
        if (count($cartCheck) > 0) {
            $cartExist = DetailCart::where('id_varian', $request->input('id_varian'))->where('id_cart', $cartCheck[0]->id)->get();
            if (count($cartExist) > 0) {
                DetailCart::where('id_varian', $request->input('id_varian'))->where('id_cart', $cartCheck[0]->id)
                ->update(
                    [
                        'qty' => $request->input('qty') + (int)$cartExist[0]->qty,
                    ]
                );
            } else {
                $brand = DetailCart::create(array_merge(
                    $validator->validated(),
                    [
                        'id_cart' => $cartCheck[0]->id,
                        'id_product' => $request->input('id_product'),
                        'qty' => $request->input('qty'),
                        'id_varian' => $request->input('id_varian'),
                        'created_at' => Carbon\Carbon::now(),
                        'updated_at' => Carbon\Carbon::now()
                    ]
                ));
            }

        } else {
            $cartNew = Cart::create([
                'id_user' => auth()->user()->id
            ]);
            if ($cartNew) {
                $brand = DetailCart::create(array_merge(
                    $validator->validated(),
                    [
                        'id_cart' => $cartNew->id,
                        'id_product' => $request->input('id_product'),
                        'qty' => $request->input('qty'),
                        'id_varian' => $request->input('id_varian'),
                        'created_at' => Carbon\Carbon::now(),
                        'updated_at' => Carbon\Carbon::now()
                    ]
                ));
            }
        }

        return $res->responsePost(true, 201, null);
    }
}
