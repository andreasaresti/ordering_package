<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProductVariantStoreRequest;
use App\Http\Requests\ProductVariantUpdateRequest;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ProductVariant::class);

        $search = $request->get('search', '');

        $productVariants = ProductVariant::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.product_variants.index',
            compact('productVariants', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ProductVariant::class);

        return view('app.product_variants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductVariantStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', ProductVariant::class);

        $validated = $request->validated();

        $productVariant = ProductVariant::create($validated);

        return redirect()
            ->route('product-variants.edit', $productVariant)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ProductVariant $productVariant): View
    {
        $this->authorize('view', $productVariant);

        return view('app.product_variants.show', compact('productVariant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ProductVariant $productVariant): View
    {
        $this->authorize('update', $productVariant);

        return view('app.product_variants.edit', compact('productVariant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ProductVariantUpdateRequest $request,
        ProductVariant $productVariant
    ): RedirectResponse {
        $this->authorize('update', $productVariant);

        $validated = $request->validated();

        $productVariant->update($validated);

        return redirect()
            ->route('product-variants.edit', $productVariant)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        ProductVariant $productVariant
    ): RedirectResponse {
        $this->authorize('delete', $productVariant);

        $productVariant->delete();

        return redirect()
            ->route('product-variants.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
