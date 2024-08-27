<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'orders' => [
        'name' => 'Orders',
        'index_title' => 'Orders List',
        'new_title' => 'New Order',
        'create_title' => 'Create Order',
        'edit_title' => 'Edit Order',
        'show_title' => 'Show Order',
        'inputs' => [
            'user_id' => 'User',
            'date' => 'Date',
            'subtotal_amount' => 'Subtotal Amount',
            'shipping_amount' => 'Shipping Amount',
            'discount' => 'Discount',
            'total_amount' => 'Total Amount',
        ],
    ],

    'order_items' => [
        'name' => 'Order Items',
        'index_title' => 'OrderItems List',
        'new_title' => 'New Order item',
        'create_title' => 'Create OrderItem',
        'edit_title' => 'Edit OrderItem',
        'show_title' => 'Show OrderItem',
        'inputs' => [
            'order_id' => 'Order',
            'product_id' => 'Product',
            'product_variant_id' => 'Product Variant',
            'name' => 'Name',
            'price' => 'Price',
            'quantity' => 'Quantity',
            'total_price' => 'Total Price',
        ],
    ],

    'products' => [
        'name' => 'Products',
        'index_title' => 'Products List',
        'new_title' => 'New Product',
        'create_title' => 'Create Product',
        'edit_title' => 'Edit Product',
        'show_title' => 'Show Product',
        'inputs' => [
            'name' => 'Name',
            'price' => 'Price',
        ],
    ],

    'product_variants' => [
        'name' => 'Product Variants',
        'index_title' => 'ProductVariants List',
        'new_title' => 'New Product variant',
        'create_title' => 'Create ProductVariant',
        'edit_title' => 'Edit ProductVariant',
        'show_title' => 'Show ProductVariant',
        'inputs' => [
            'color' => 'Color',
            'size' => 'Size',
            'price' => 'Price',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],
];
