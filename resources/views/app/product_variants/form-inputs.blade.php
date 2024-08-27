@php $editing = isset($productVariant) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="colour"
            label="Colour"
            :value="old('colour', ($editing ? $productVariant->colour : ''))"
            maxlength="9"
            placeholder="Colour"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="size"
            label="Size"
            :value="old('size', ($editing ? $productVariant->size : ''))"
            max="255"
            step="0.01"
            placeholder="Size"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="price"
            label="Price"
            :value="old('price', ($editing ? $productVariant->price : ''))"
            max="255"
            step="0.01"
            placeholder="Price"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
