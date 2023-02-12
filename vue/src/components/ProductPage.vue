<template>
    <div class="mt-10">
        <div>
            <img :src="props.image" class="h-96" :class="{
                   'grayscale' : props.available === 0
               }"/>
        </div>
        <div class="flex flex-col">
            <h1>{{props.name}} (ID: {{props.id}})</h1>
            <p>{{props.price}}</p>
            <p>In stock:{{props.available}}</p>
            <button class="flex flex-row bg-orange-500 hover:bg-orange-400">Add to cart<ShoppingCartIcon class="h-6 w-6"/></button>
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
