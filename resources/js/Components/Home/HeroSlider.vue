<template>
    <div class="relative  w-full overflow-hidden md:rounded-xl shadow-lg">
        <!-- Slides -->
        <div
            class="flex transition-transform duration-700 ease-in-out"
            :style="{ transform: `translateX(-${currentSlide * 100}%)` }"
        >
            <div
                v-for="(slide, index) in slides"
                :key="index"
                class="w-full flex-shrink-0 relative"
            >
                <img
                    :src="slide.image"
                    :alt="slide.title"
                    class="w-full h-64 md:h-96 object-cover"
                />
                <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-center text-white p-4">
                    <h2 class="text-2xl md:text-4xl font-bold mb-2">{{ slide.title }}</h2>
                    <p class="text-sm md:text-lg mb-4">{{ slide.subtitle }}</p>
                    <Link
                        :href="slide.link"
                        class="bg-secondary text-white font-semibold px-4 py-2 rounded-lg hover:bg-opacity-90 transition"
                    >
                        {{ slide.button }}
                    </Link>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <button
            @click="prevSlide"
            class="absolute top-1/2 left-3 -translate-y-1/2 bg-secondary text-white p-2 rounded-full"
        >
            ‹
        </button>
        <button
            @click="nextSlide"
            class="absolute top-1/2 right-3 -translate-y-1/2 bg-secondary text-white p-2 rounded-full"
        >
            ›
        </button>

        <!-- Indicators -->
        <div class="absolute bottom-3 left-0 right-0 flex justify-center space-x-2">
      <span
          v-for="(slide, index) in slides"
          :key="index"
          @click="currentSlide = index"
          class="w-3 h-3 rounded-full cursor-pointer"
          :class="index === currentSlide ? 'bg-secondary' : 'bg-white/70'"
      ></span>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { Link } from "@inertiajs/vue3";

const slides = [
    {
        title: "Know the right price before you buy or repair.",
        subtitle: "Compare prices and make smarter tech decisions.",
        button: "Check Prices",
        image: "https://i.pinimg.com/736x/be/96/d9/be96d94c5fcfe8cedec05970843a9c38.jpg",
        link: "/accessories?tab=Accessories",
    },

    {
        title: "Your phone deserves expert hands.",
        subtitle: "Find trusted repairers near you — fast, reliable, affordable.",
        button: "Find Repairers",
        image: "https://i.pinimg.com/736x/54/b3/f0/54b3f0e6feaf2bd77ac1e009fa6185e0.jpg",
        link: "/",
    },
    {
        title: "Upgrade your tech life.",
        subtitle: "Shop accessories from verified vendors.",
        button: "Browse Accessories",
        image: "https://www.oteamstore.com/cdn/shop/articles/BO1.png?v=1704642596",
        link: "/accessories?tab=Accessories",
    },
    {
        title: "Discover trusted vendors near you.",
        subtitle: "All your favorite gadgets in one place.",
        button: "Explore Vendors",
        image: "https://i.pinimg.com/736x/62/53/c8/6253c8f3f42ff6b312ac4c455d89d636.jpg",
        link: "/accessories?tab=Vendors",
    },
];

const currentSlide = ref(0);
let interval = null;

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % slides.length;
};
const prevSlide = () => {
    currentSlide.value =
        (currentSlide.value - 1 + slides.length) % slides.length;
};

onMounted(() => {
    interval = setInterval(nextSlide, 5000);
});
onUnmounted(() => clearInterval(interval));
</script>
