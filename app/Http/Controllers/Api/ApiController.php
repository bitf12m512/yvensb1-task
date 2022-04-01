<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'class' => 'required|string|max:255',
			'variants' => 'required|string',
			'price' => 'required|numeric',
			'image' => 'required|file',
			'status' => 'required|string|max:255',
		]);

		if ($validator->fails()) {
			return response(['errors' => $validator->errors()->all()], 422);
		}

		$data = $request->all();

        $product = Product::create($request->toArray());

        if (isset($data['image'])) {
			$filename   = time() . rand(111, 699) . '_' . $data['image']->getClientOriginalName();
			$data['image']->move("upload/", $filename);
			$product->image = $filename;
		}

		$product->save();

		$response = ['success' => true];
		return response($response, 200);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::find($id);

        if ($product == null) {
            $response = "Product not found";
            return response($response, 404);
        }

		$data = $request->all();

        $product->fill($data);

        if (isset($data['image'])) {
			$filename   = time() . rand(111, 699) . '_' . $data['image']->getClientOriginalName();
			$data['image']->move("upload/", $filename);
			$product->image = $filename;
		}

		$product->save();

		$response = ['success' => true];
		return response($response, 200);
    }

    public function deleteProduct(Request $request, $id)
	{
		Product::where('id', $id)->delete();

		$response = ['success' => true];
		return response($response, 200);
	}

    public function getProducts(Request $request)
    {
        $products = Product::orderBy("created_at", "DESC");

        if(isset($_GET["name"])) {
            $products = $products->where("name", $_GET["name"]);
        }

        if(isset($_GET["class"])) {
            $products = $products->where("class", $_GET["class"]);
        }

        if(isset($_GET["status"])) {
            $products = $products->where("status", $_GET["status"]);
        }

        $products = $products->select("id", "name", "status")->get();

        $response = ['data' => $products];

        return response($response, 200);
    }

    public function getProduct(Request $request, $id)
    {
        $product = Product::find($id);

        if ($product == null) {
            $response = "Product not found";
            return response($response, 404);
        }

        $product->variants = json_decode($product->variants);

        return response($product, 200);
    }
}
