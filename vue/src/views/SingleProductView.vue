<template>
    <MainContainer>
        <div v-if="state.isLoading">
            <Spinner/>
        </div>
        <div v-if="state.product">
            <ProductPage
                :id="state.product.id"
                :name="state.product.name"
                :available="state.product.available"
                :price="state.product.price"
                :image="state.product.image"/>
        </div>
    </MainContainer>
</template>

<script setup lang="ts">
import {onMounted, reactive, ref} from "vue";
import axios from "axios";
import {useRoute, useRouter} from "vue-router";
import ProductPage from '../components/ProductPage.vue';
import MainContainer from '../components/MainContainer.vue';
import Spinner from "../components/Spinner.vue";

const route = useRoute();
const router = useRouter();

const productId = route.params.id;

const state = reactive({
    product: null as Product | null,
    isLoading: false,
    isError: false,
});

onMounted(() => {
    fetchData();
});

const url = ref(`http://127.0.0.1:8000/api/v1/products/${productId}`);

const fetchData = async () => {
    try {
        state.isLoading = true;
        const {data} = await axios.get(url.value);
        state.product = data[0];
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

const props = defineProps<Product>()
</script>

