<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProductResource;
use App\Models\API\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    /*
    {
        "name" : "data 1"
    }
    */
    //localhost:8000/api/product/insert
    public function insert(Request $r)
    {
        try {
            $input = array(
                'name' => 'required|string|min:1'
            );

            $validator = Validator::make($r->all(), $input);

            if ($validator->fails()) {
                $apiResponse = $this->getApiResponse(0);
                $apiResponse->message = $validator->getMessageBag();
                return $this->responseFailed($apiResponse);
            }

            DB::beginTransaction();

            ProductModel::create($r->all());

            DB::commit();

            $apiResponse = $this->getApiResponse(1);
            return $this->responseSuccess($apiResponse);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseError($th);
        }
    }

    //localhost:8000/api/product/all
    public function all()
    {
        try {
            $result = ProductModel::all();

            return $this->toList(ProductResource::collection($result), 1, 0);
        } catch (\Throwable $th) {
            return $this->responseError($th);
        }
    }

    //http://localhost:8000/api/product/paging?limit=10&page=1&start_date=2023-01-01&end_date=2023-01-01
    public function paging(Request $r)
    {
        try {
            $limit = $r->limit ? $r->limit : 10;
            $page = $r->page ? $r->page : 1;
            $start_date = $r->start_date;
            $end_date = $r->end_date;

            $query = DB::table('product');

            if ($start_date) {
                $query = $query->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date);
            }

            $dataParsing = $query;

            return $this->toPaging(
                1,
                $dataParsing,
                $limit,
                $page
            );
        } catch (\Throwable $th) {
            return $this->responseError($th);
        }
    }

    /*
    {
        "name" : "Data 1 Update"
    }
    */
    //localhost:8000/api/product/update/
    public function update(Request $r, $id)
    {
        try {
            $input = array(
                'name' => 'required|string|min:1'
            );

            $validator = Validator::make($r->all(), $input);

            if ($validator->fails()) {
                $apiResponse = $this->getApiResponse(0);
                $apiResponse->message = $validator->getMessageBag();
                return $this->responseFailed($apiResponse);
            }

            DB::beginTransaction();

            $result = ProductModel::find($id);
            $result->name = $r->name;
            $result->save();

            DB::commit();

            $apiResponse = $this->getApiResponse(1);
            return $this->responseSuccess($apiResponse);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseError($th);
        }
    }

    //localhost:8000/api/product/delete/
    public function delete($id)
    {
        try {
            $result = ProductModel::find($id);

            DB::beginTransaction();

            $result->delete();

            DB::commit();

            $apiResponse = $this->getApiResponse(1);
            return $this->responseSuccess($apiResponse);
        } catch (\Throwable $th) {
            return $this->responseError($th);
        }
    }

    //localhost:8000/api/product/find/
    public function find($id)
    {
        try {
            $result = ProductModel::find($id);

            return $this->toObject(new ProductResource($result), 1, 0);
        } catch (\Throwable $th) {
            return $this->responseError($th);
        }
    }
}
