<?php

namespace App\Http\Controllers\API;

use Response;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ProductsResource;
use App\Repositories\ProductsRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateProductsAPIRequest;
use App\Http\Requests\API\UpdateProductsAPIRequest;

/**
 * Class ProductsController
 * @package App\Http\Controllers\API
 */

class ProductsAPIController extends AppBaseController
{
    /** @var  ProductsRepository */
    private $productsRepository;

    public function __construct(ProductsRepository $productsRepo)
    {
        $this->productsRepository = $productsRepo;
    }

    /**
     * Display a listing of the Products.
     * GET|HEAD /products
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $products = $this->productsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        $opArray = [];
        if (count($products) > 0) {
            foreach ($products as $productKey => $product) {
                Log::info('___PRODUCT_____', [$product]);
                if (isset($product->features) && isset($product->features["page_setup"])) {
                    $opArray[$productKey] = $product->toArray();
                    foreach ($product->features["page_setup"] as $key => $page) {
                        $opArray[$productKey]["features"]["page_setup"][$key] = htmlspecialchars_decode($page);
                        Log::info("___OP ARRAY ____ ", [$opArray]);
                    }
                }
            }
        }
        return response()->json([
            "error" => 0,
            "data" => $opArray,
            "message" => "Products fetched successfully.",
            "show_message"=> false
        ]);
        // return $this->sendResponse(ProductsResource::collection($products), 'Products retrieved successfully');
    }

    /**
     * Store a newly created Products in storage.
     * POST /products
     *
     * @param CreateProductsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateProductsAPIRequest $request)
    {
        $input = $request->all();

        $products = $this->productsRepository->create($input);

        return $this->sendResponse(new ProductsResource($products), 'Products saved successfully');
    }

    /**
     * Display the specified Products.
     * GET|HEAD /products/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Products $products */
        $products = Products::find($id) ;

        if (empty($products)) {
            return response()->json([
                "error" => 1,
                "message" => "No product found.",
                "data" => [],
                "show_message" => false
            ]);
        }
        $opArray = [];
        Log::info("___PRODUCT___", [$products]);
        if (isset($products->features) && isset($products->features["page_setup"])) {
            $opArray = $products->toArray();
            foreach ($products->features["page_setup"] as $key => $page) {
                $opArray["features"]["page_setup"][$key] = htmlspecialchars_decode($page);
            }
        }
        return response()->json([
            "error" => 0,
            "data" => $opArray,
            "message" => "Products fetched successfully.",
            "show_message" => false
        ]);
        // return $this->sendResponse(new ProductsResource($products), 'Products retrieved successfully');
    }

    /**
     * Update the specified Products in storage.
     * PUT/PATCH /products/{id}
     *
     * @param int $id
     * @param UpdateProductsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductsAPIRequest $request)
    {
        $input = $request->all();

        /** @var Products $products */
        $products = $this->productsRepository->find($id);

        if (empty($products)) {
            return $this->sendError('Products not found');
        }

        $products = $this->productsRepository->update($input, $id);

        return $this->sendResponse(new ProductsResource($products), 'Products updated successfully');
    }

    /**
     * Remove the specified Products from storage.
     * DELETE /products/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Products $products */
        $products = $this->productsRepository->find($id);

        if (empty($products)) {
            return $this->sendError('Products not found');
        }

        $products->delete();

        return $this->sendSuccess('Products deleted successfully');
    }
}
