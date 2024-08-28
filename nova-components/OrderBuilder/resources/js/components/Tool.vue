<template>
  <h1 class="text-lg font-semibold">Order Builder</h1>  
  <ul>
    <!-- Order Items -->
    <li v-for="item in order.items" :key="item.id" class="p-1">
      <div class="flex flex-1 bg-white">
        <div class="flex-auto pl-5 pt-2">{{ item.product.name }}</div>
        <div class="flex-auto pt-2">{{item.variant.name}}</div>
        <div class="text-center w-48">
          <input type="number" v-model="item.quantity" @change="updateItem(item)" class="w-full form-control form-input form-input-bordered"/></div>
        <div class="text-center w-48">
          <input type="number" v-model="item.price" @change="updateItem(item)" class="w-full form-control form-input form-input-bordered" /></div>
        <div class="pt-2 text-center w-48">{{(item.price * item.quantity)}}</div>
        <div class="text-right"><button @click="removeItem(item.id)" class="flex-shrink0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-red-500 hover:bg-red-400 active:bg-red-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0">Remove</button></div>
      </div>
    </li>
    <!-- Order Totals -->
    <li>
      <div class="flex flex-1 bg-white">
        <div class="flex-auto pl-5 pt-2">Subtotal</div>
        <div class="pt-2 text-center w-48">{{order.subtotal}}</div>
      </div>
      <div>
        <div class="flex flex-1 bg-white">
          <div class="flex-auto pl-5 pt-2">Tax</div>
          <div class="pt-2 text-center w-48">{{order.tax}}</div>
        </div>
      </div>
      <div>
        <div class="flex flex-1 bg-white">
          <div class="flex-auto pl-5 pt-2">Total</div>
          <div class="pt-2 text-center w-48">{{order.total}}</div>
        </div>
      </div>
    </li>
    <!-- New Entry line -->
    <li>
      <div class="flex">
        <div class="flex-auto">
          <select v-model="product" class="w-full form-control form-input form-input-bordered" @change="changeProduct($event.target.value)">
            <option v-for="product in products" :key="product.id" :value="product.id">
              {{ product.name }}
            </option>
          </select>
        </div>
        <div class="flex-auto">
          <select v-model="variant" class="w-full form-control form-input form-input-bordered"  >
            <option v-for="variant in variants" :key="variant.id" :value="variant.id">
              {{ variant.name }}
            </option>
          </select>
        </div>
        <div class="flex-auto">
          <input v-model="quantity" type="number" class="w-full form-control form-input form-input-bordered" />
        </div>
        <div><button class="flex-shrink0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0" @click="addItem">Add Item</button></div>
      </div>
    </li>
  </ul>
  <!-- modal for options -->
  

</template>

<script>

export default {
  props: ['resourceName', 'resourceId', 'panel'],
  data() {
    return {
      product: null,
      variant: null,
      quantity: 1,
      products: [],
      variants: [],
      order: {
        subtotal: 0,
        tax: 0,
        total: 0
      }
    };
  },
  mounted() {
    this.loadOrder();
    this.loadProducts();
  },
  methods: {
    changeProduct(productId) {
      this.loadVariants(productId);
    },
    loadOrder() {
      Nova.request().get(`/nova-vendor/order-builder/order/${this.resourceId}`)
        .then(response => {
          this.order = response.data;
          this.items = response.data.items;
        });
    },
    loadProducts() {
      Nova.request()
        .get('/nova-vendor/order-builder/products')
        .then((response) => {
          this.products = response.data;
        });
    },
    loadVariants(productId) {
      Nova.request()
        .get('/nova-vendor/order-builder/products/' + productId+ '/variants')
        .then((response) => {
          this.variants = response.data;
        });
    },
    addItem() {
      const item = this.items.find(item => item.variant.id == this.variant);
      Nova.request()
        .post('/nova-vendor/order-builder/order/'+this.resourceId+'/items', {
          product_id: this.product,
          variant_id: this.variant,
          quantity: this.quantity,
        })
        .then((response) => {
          this.order = response.data;
        });
    },
    updateItem(item) {
      Nova.request()
        .put('/nova-vendor/order-builder/order/'+this.resourceId+'/items/'+item.id, {
          quantity: item.quantity,
          price: item.price, 
        })
        .then((response) => {
          this.order = response.data;
        });
    },
    removeItem(id) {
      Nova.request()
        .delete('/nova-vendor/order-builder/order/'+this.resourceId+'/items/'+id)
        .then((response) => {
          this.order = response.data;
        });
    },
  },
}
</script>
