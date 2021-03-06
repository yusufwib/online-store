<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailCart;
use App\Models\Transaction;
use App\Models\Cart;
use App\Helper\ResponseHelper as JsonHelper;
use Carbon, Validator, Log;

class TransactionController extends Controller
{
    public function addToCart (Request $request) {
        $res = new JsonHelper;
        Log::debug('function: addToCart');
        $validator = Validator::make($request->all(), [
            'qty' => 'required',
        ]);
        if($validator->fails()){
            Log::error('function: addToCart [validator fail]');
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

    public function addToCheckout (Request $request) {
        $res = new JsonHelper;
        Log::debug('function: addToCheckout');
        $validator = Validator::make($request->all(), [
            'id_cart' => 'required',
        ]);

        if($validator->fails()){
            Log::error('function: addToCheckout [validator fail]');
            return $res->responseGet(false, 400, '', $validator->errors());
        }

        $orderCheck = Transaction::where('id_cart', $request->input('id_cart'))->where('id_user', auth()->user()->id)->get();
        $orderToday = Transaction::whereDate('created_at', Carbon\Carbon::today())->get();
        $numOfTodaY = (int)count($orderToday) + 1;
        if (count($orderCheck) > 0) {
            Transaction::where('id_cart', $request->input('id_cart'))->where('id_user', auth()->user()->id)->delete();
            $order = Transaction::create(array_merge(
                $validator->validated(),
                [
                    'inv' => 'INV' . Carbon\Carbon::now()->format('YmdHis') . '' . $numOfTodaY,
                    'id_cart' => $request->input('id_cart'),
                    'id_user' => auth()->user()->id,
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ]
            ));
            return $res->responsePost(true, 201, null);
        } else {
            $order = Transaction::create(array_merge(
                $validator->validated(),
                [
                    'inv' => 'INV' . Carbon\Carbon::now()->format('Ymd') . '' . $numOfTodaY,
                    'id_cart' => $request->input('id_cart'),
                    'id_user' => auth()->user()->id,
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ]
            ));
        }
        return $res->responsePost(true, 201, null);
    }
}
