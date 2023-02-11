<template>
    <MainContainer>
        <div v-if="state.isLoading">
            <Spinner/>
        </div>
        <div v-else>
            <ul class="flex flex-row flex-wrap justify-center mx-12 my-8">
                <li v-for="product in state.products" :key="product.id">
                    <ProductCard :id="product.id" :name="product.name" :available="product.available"
                                 :price="product.price" :image="product.image"/>
                    <h1>{{product.image_url}}</h1>
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
    fetchData();
    console.log(state.products);
});

const url = ref("http://127.0.0.1:8000/api/v1/products");

const fetchData = async () => {
    try {
        state.isLoading = true;
        const {data} = await axios.get(url.value);
        console.log(data)
        state.products = data.map((product: any) => {
            return ({
                id: product.id,
                name: product.name,
                available: product.available,
                price: product.price,
                image: product.image_url,
            })
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
    image_url: string;
}
</script>
