<template>
    <MainContainer>
        <div v-if="state.isLoading" class="mt-24">
            <Spinner/>
        </div>
        <div v-else>
            <ul class="flex flex-row flex-wrap justify-center mx-12 my-8">
                <li v-for="product in state.products" :key="product.id">
                    <ProductCard :id="product.id" :name="product.name" :available="product.available"
                                 :price="product.price" :image="product.image"/>
                </li>
            </ul>
        </div>
    </MainContainer>
</template>

<script setup lang="ts">
import {onMounted, reactive, ref} from "vue";
import axios from "axios";
import MainContainer from '../components/MainContainer.vue';
import Spinner from "../components/Spinner.vue";
import ProductCard from "../components/ProductCard.vue"

const state = reactive({
    products: [] as Product[],
    isLoading: false,
    isError: false,
});

onMounted(() => {
    fetchProducts();
});

const url = ref("http://127.0.0.1:8000/api/v1/stock");

const fetchProducts = async () => {
    try {
        state.isLoading = true;
        const {data} = await axios.get(url.value);
        state.products = data.data.map((product: Product) => {
            return ({
                id: product.id,
                name: product.name,
                available: product.available,
                price: product.price,
                image: product.image,
            });
        });
        state.isLoading = false;
    } catch (error) {
        console.log("error", error);
        state.isLoading = false;
        state.isError = true;
    }
};

interface Product {
    id: number;
    name: string;
    available: number;
    price: number;
    image: string;
}
</script>
