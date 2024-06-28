<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
//    public function index ()
//    {
//        $DEFAULT_PER_PAGE = 10;
//        $perPage = request()->query('per_page', $DEFAULT_PER_PAGE); // Default to 10 if not provided
//        $companyCode = request()->query('company_code', '');
//
//        $query = Product::query();
//
//        if ($companyCode) {
//            $query->whereRelation('company', 'company_code', $companyCode);
//        }
//
//        $products = $query->orderBy('created_at')->paginate($perPage);
//        return ProductResource::collection($products);
//    }

    public function index ()
    {
        $defaultPerPage = 10;
        $perPage = request()->query('per_page', $defaultPerPage);

        $products = QueryBuilder::for(Product::class)
            ->allowedFilters([
                AllowedFilter::partial(
                    'company_code',
                    'company.company_code'
                )->ignore([null, '']),
//                'company.company_code',
                'name',
            ])
            ->with(['company'])
            ->paginate($perPage);

        return ProductResource::collection($products);
    }

    public function store (Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:products|max:255',
            'description' => 'max:255',
            'price' => 'required',
        ]);

        $product = Product::create($validated);

        return ProductResource::make($product);
    }

    public function update (Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('products')->ignore($product),
            ],
            'description' => 'max:255',
            'price' => 'required',
        ]);

        $product->update($validated);

        return ProductResource::make($product);
    }

    public function destroy (Product $product) {
        $product->delete();

        return response()->json(null, 204);
    }

    public function show (Product $product) {
        return ProductResource::make($product);
    }
}
