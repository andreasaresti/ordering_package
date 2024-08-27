<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductVariantResource;
use App\Http\Resources\ProductVariantCollection;
use App\Http\Requests\ProductVariantStoreRequest;
use App\Http\Requests\ProductVariantUpdateRequest;

class ProductVariantController extends Controller
{
    public function index(Request $request): ProductVariantCollection
    {
        $this->authorize('view-any', ProductVariant::class);

        $search = $request->get('search', '');

        $productVariants = ProductVariant::search($search)
            ->latest()
            ->paginate();

        return new ProductVariantCollection($productVariants);
    }

    public function store(
        ProductVariantStoreRequest $request
    ): ProductVariantResource {
        $this->authorize('create', ProductVariant::class);

        $validated = $request->validated();

        $productVariant = ProductVariant::create($validated);

        return new ProductVariantResource($productVariant);
    }

    public function show(
        Request $request,
        ProductVariant $productVariant
    ): ProductVariantResource {
        $this->authorize('view', $productVariant);

        return new ProductVariantResource($productVariant);
    }

    public function update(
        ProductVariantUpdateRequest $request,
        ProductVariant $productVariant
    ): ProductVariantResource {
        $this->authorize('update', $productVariant);

        $validated = $request->validated();

        $productVariant->update($validated);

        return new ProductVariantResource($productVariant);
    }

    public function destroy(
        Request $request,
        ProductVariant $productVariant
    ): Response {
        $this->authorize('delete', $productVariant);

        $productVariant->delete();

        return response()->noContent();
    }
}
