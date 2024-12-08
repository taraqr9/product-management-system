<?php

namespace App\Http\Controllers\Api;

use App\Enums\RoleEnum;
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

    public function store(ProductStoreRequest $request): JsonResponse
    {
        if (! auth()->user()->hasRole(RoleEnum::ADMIN->value)) {
            return response()->json([
                'status' => 403,
                'message' => 'Unauthorized action: only admins can delete users',
            ], 403);
        }

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
        if (! auth()->user()->hasRole(RoleEnum::ADMIN->value)) {
            return response()->json([
                'status' => 403,
                'message' => 'Unauthorized action: only admins can delete users',
            ], 403);
        }

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
        if (! auth()->user()->hasRole(RoleEnum::ADMIN->value)) {
            return response()->json([
                'status' => 403,
                'message' => 'Unauthorized action: only admins can delete users',
            ], 403);
        }
        
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
