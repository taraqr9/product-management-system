<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('product-list|product-show'), only: ['index', 'show']),
            new Middleware(PermissionMiddleware::using('product-create'), only: ['create', 'store']),
            new Middleware(PermissionMiddleware::using('product-edit'), only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::using('product-delete'), only: ['destroy']),
        ];
    }

    public function store(ProductStoreRequest $request): JsonResponse
    {
        try {
            $product = $this->productRepository->createProduct($request->validated());

            return response()->json([
                'status' => 200,
                'message' => 'Product created successfully',
                'product' => $product,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Product creation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(ProductUpdateRequest $request, $id): JsonResponse
    {
        try {
            $product = $this->productRepository->updateProduct($request->validated(), $id);

            return response()->json([
                'status' => 200,
                'message' => 'Product updated successfully',
                'product' => $product,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Product update failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->productRepository->deleteProduct($id);

            return response()->json([
                'status' => 200,
                'message' => 'Product deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Product deletion failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $product = $this->productRepository->getProduct($id);

            return response()->json([
                'status' => 200,
                'product' => $product,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Product not found',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index(): JsonResponse
    {
        try {
            $products = $this->productRepository->getAllProducts();

            return response()->json([
                'status' => 200,
                'products' => $products,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve products',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
