<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\AssetProduct;
use App\Models\DetailProduct;
use App\Models\CategoryProduct;
use App\Helper\ResponseHelper as JsonHelper;
use Validator, Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function createProduct (Request $request) {
        $res = new JsonHelper;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'description' => 'required|string',
            'weight' => 'required',
            'id_brand' => 'required'
        ]);

        if($validator->fails()){
            return $res->responseGet(false, 400, '', $validator->errors());
        }
        $product = Product::create(array_merge(
            $validator->validated(),
            [
                'active' => 1,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ]
        ));

        if ($product) {
            $array = ($request->input('varians'));
            $varians = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $array), true );
                foreach ($varians as $key => $v) {
                    $detVar =  new DetailProduct;
                    $detVar->size = $v['size'];
                    $detVar->color = $v['color'];
                    $detVar->sku = $v['sku'];
                    $detVar->id_product = $product->id;
                    $detVar->stock = $v['stock'];
                    $detVar->created_at = Carbon\Carbon::now();
                    $detVar->updated_at = Carbon\Carbon::now();
                    $detVar->save();
                }

            if ($request->hasfile('images')) {
                foreach($request->file('images') as $i) {
                    
                    $name = 'product-' . uniqid() . $res->generateRandomString(30) . '.'.$i->getClientOriginalExtension();
                    Storage::disk('public')->put($name,File::get($i));
                    AssetProduct::insert([
                        'id_product' => $product->id,
                        'url' => $name,
                        'created_at' => Carbon\Carbon::now(),
                        'updated_at' => Carbon\Carbon::now()
                    ]);
                }
            } else {
                Product::where('id', $product->id)->delete();
                return $res->responseGet(false, 400, [], null);
            }
            return $res->responsePost(true, 200, '');
        }
    }

    public function getProduct (Request $request) {
        $res = new JsonHelper;

        $search_query = $request->input('search_query');

        $data = Product::where('products.name', 'like', '%' . $search_query . '%')->get();

        foreach ($data as $k => $v) {
            $assets = AssetProduct::where('id_product', $v->id)->get();
            $data[$k]->assets = $assets;

            $detailVarian = DetailProduct::where('id_product', $v->id)->get();
            $data[$k]->detail_varian = $detailVarian;
        }
        return $res->responseGet(true, 200, $data, null);
    }
}
