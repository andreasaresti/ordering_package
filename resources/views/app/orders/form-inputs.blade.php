@php $editing = isset($order) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $order->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($order->date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="subtotal_amount"
            label="Subtotal Amount"
            :value="old('subtotal_amount', ($editing ? $order->subtotal_amount : ''))"
            max="255"
            step="0.01"
            placeholder="Subtotal Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="shipping_amount"
            label="Shipping Amount"
            :value="old('shipping_amount', ($editing ? $order->shipping_amount : ''))"
            max="255"
            step="0.01"
            placeholder="Shipping Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="discount"
            label="Discount"
            :value="old('discount', ($editing ? $order->discount : ''))"
            max="255"
            step="0.01"
            placeholder="Discount"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="total_amount"
            label="Total Amount"
            :value="old('total_amount', ($editing ? $order->total_amount : ''))"
            max="255"
            step="0.01"
            placeholder="Total Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
