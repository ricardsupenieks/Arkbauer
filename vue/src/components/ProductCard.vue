<template>
    <RouterLink :to="`recipes/${props.id}`">
        <div class="max-w-sm rounded overflow-hidden shadow-lg">
            <div class="h-40 w-48 overflow-hidden">
                <img class="object-scale-down object-center px-2 mt-4" :src="props.image" :alt="props.name">
            </div>
            <div class="pl-1 pb-1">
                <div class="font-bold text-md my-1">{{props.price / 100}}$</div>
                <p class="text-gray-700 text-base">
                    {{props.name}}$
                </p>
            </div>
        </div>
    </RouterLink>
</template>

<script setup lang="ts">
interface Product {
    id: number;
    name: string;
    available: number;
    price: number;
    image: string;

}

const props = defineProps<Product>()
</script>
