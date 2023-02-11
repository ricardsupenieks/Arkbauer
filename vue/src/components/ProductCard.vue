<template>
    <div v-if="props.available > 0">
        <RouterLink to="/#">
            <div class="max-w-sm rounded overflow-hidden bg-white border hover:shadow-lg">
                <div class="h-40 w-52 overflow-hidden relative">
                    <ShoppingCartIcon class="h-8 w-8 absolute ml-44 mt-2 bg-white rounded-full p-1 hover:text-red-700"/>
                    <img class="object-scale-down w-48 object-center px-2 mt-4 mx-auto" :src="props.image" :alt="props.name">
                </div>
                <div class="pl-1 pb-1">
                    <p class="font-bold text-md my-1">{{props.price / 100}}$</p>
                    <p class="text-gray-700 text-base">
                        {{props.name}}$
                    </p>
                </div>
            </div>
        </RouterLink>
    </div>
    <div v-else>
        <div class="max-w-sm rounded overflow-hidden bg-white border cursor-not-allowed	">
            <div class="h-40 w-52 overflow-hidden relative">
                <img class="object-scale-down w-48 object-center px-2 mt-4 mx-auto grayscale" :src="props.image" :alt="props.name">
            </div>
            <div class="pl-1 pb-1">
                <p class="font-bold text-md text-center my-4">OUT OF STOCK</p>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ShoppingCartIcon } from '@heroicons/vue/24/outline'

interface Product {
    id: number;
    name: string;
    available: number;
    price: number;
    image: string;

}

const props = defineProps<Product>()
</script>
