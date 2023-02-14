<template>
  <div>
      <header>
          <RouterLink to="/">
              <h1 class="text-center py-4 font-mono font-extrabold text-2xl bg-black text-white">COMPANY NAME</h1>
          </RouterLink>
          <nav class="flex flex-row justify-between border border-black font-mono py-2 bg-white">
              <div/>
              <div class="flex flex-row gap-12 mt-1 ml-48">
                  <RouterLink to="/" class="hover:-translate-y-0.5 hover:scale-100 transition ease-in-out delay-90">CATALOG</RouterLink>
                  <RouterLink to="/#" class="hover:-translate-y-0.5 hover:scale-102 transition ease-in-out delay-90">BESTSELLERS</RouterLink>
                  <RouterLink to="/#" class="hover:-translate-y-0.5 hover:scale-102 transition ease-in-out delay-90">ABOUT</RouterLink>
                  <RouterLink to="/#" class="hover:-translate-y-0.5 hover:scale-102 transition ease-in-out delay-90">CONTACT</RouterLink>
              </div>

                <Popover>
                    <PopoverButton class="focus:outline-none">
                        <ShoppingBagIcon class="h-6 w-6 mr-6 ml-48" @click="fetchCart"/>
                    </PopoverButton>

                    <transition
                        enter-active-class="transition duration-200 ease-out"
                        enter-from-class="translate-y-1 opacity-0"
                        enter-to-class="translate-y-0 opacity-100"
                        leave-active-class="transition duration-150 ease-in"
                        leave-from-class="translate-y-0 opacity-100"
                        leave-to-class="translate-y-1 opacity-0"
                    >
                        <PopoverPanel class="z-10 w-full">
                            <div v-if="state.products.length !== 0">
                                <div class="absolute mt-3">
                                    <div class="flex flex-col relative bg-white p-6 rounded-lg border">
                                        <div v-for="product in state.products" :key="product.id">
                                            <div class="flex flex-row gap-12 text-sm">
                                                <p>{{ product.name }}</p>
                                                <p>{{ product.price }}$</p>
                                            </div>
                                            <p class="text-gray-600 underline text-xs cursor-pointer w-auto" @click="removeProduct(product.id)">remove</p>
                                        </div>
                                        <div class="flex flex-col mt-3 text-sm">
                                            <p class="text-end">Subtotal: {{ state.subtotal }}$</p>
                                            <p class="text-end">Vat amount: {{ state.vatAmount }}$</p>
                                            <p class="text-end">Total: {{ state.total }}$</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <div class="absolute mt-3">
                                    <p class="relative bg-white p-6 rounded-lg border text-sm w-[207px] text-center">
                                        Cart empty
                                    </p>
                                </div>
                            </div>
                        </PopoverPanel>
                    </transition>
                </Popover>
          </nav>
      </header>
      <RouterView />
  </div>
</template>

<script setup lang="ts">
import { ShoppingBagIcon } from '@heroicons/vue/24/solid'
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
import axios from 'axios';
import { reactive, ref } from 'vue';
import { RouterLink, RouterView } from 'vue-router';

const url = ref('http://127.0.0.1:8000/api/v1/cart/');

const state = reactive({
    products: [] as Product[],
    subtotal: 0,
    vatAmount: 0,
    total: 0,
    isLoading: false,
    isError: false,
});

const fetchCart = async () => {
    try {
        const {data} = await axios.get(url.value);
        state.products = data.products.map((product: Product) => {
            return ({
                id: product.id,
                name: product.name,
                availab: product.available,
                price: product.price,
                vatRate: product.vatRate,
                image: product.image,
            })
        });
        console.log(data);
        state.subtotal = data.subtotal;
        state.vatAmount = data.vatAmount;
        state.total = data.total;
    } catch (error) {
        console.log("error", error);
        state.isError = true;
    }
};

const removeProduct = (productId: number) => {
    try {
        axios.delete(url.value + productId);
        let id = state.products.findIndex(product => product.id === productId);
        state.subtotal = Math.round(state.subtotal - state.products[id].price);
        state.vatAmount = Math.round(state.vatAmount - (state.products[id].price * state.products[id].vatRate));
        state.total = Math.round(state.total - (state.products[id].price + (state.products[id].price * state.products[id].vatRate)));
        state.products.splice(id, 1);

        if(state.products.length === 0) {
            state.subtotal = 0;
            state.vatAmount = 0;
            state.total = 0;
        }
    } catch (error) {
        console.log(error);
    }
}

interface Product {
    id: number;
    name: string;
    available: number;
    price: number;
    vatRate: number;
    image: string;
}
</script>
