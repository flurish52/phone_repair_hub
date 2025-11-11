<script setup>
import Checkbox from '@/Components/Checkbox.vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { ref, onMounted } from 'vue'
import axios from 'axios'
import {Link} from "@inertiajs/vue3";
const form = ref({
    login: '',
    password: '',
    remember: false,
})

const errors = ref({})
const message = ref(null)
const loading = ref(false)
const currentSlide = ref(0)

const submit = async () => {
    errors.value = {}
    message.value = null
    loading.value = true

    try {
        const response = await axios.post(route('login'), {
            login: form.value.login,
            password: form.value.password,
            remember: form.value.remember,
        })

        if (response.data.success) {
            message.value = response.data.message
            window.location.href = response.data.redirect
        } else if (response.data.error) {
            message.value = response.data.message
        }
    } catch (error) {
        if (error.response && error.response.data) {
            message.value = error.response.data.message || 'Login failed.'
            errors.value = error.response.data.errors || {}
        } else {
            message.value = 'Network error. Try again.'
        }
    } finally {
        loading.value = false
    }
}

// Auto-rotate slides
onMounted(() => {
    setInterval(() => {
        currentSlide.value = (currentSlide.value + 1) % slides.value.length
    }, 5000)
})
</script>

<template>
    <GuestLayout>
        <div class="min-h-screen flex bg-gradient-to-br from-slate-50 to-blue-50">
            <!-- Left marketing section -->
                        <div class="hidden lg:flex lg:flex-1 relative overflow-hidden">
                            <!-- Animated background gradient -->
                            <div class="absolute inset-0  bg-secondary opacity-90"></div>

                            <!-- Decorative elements -->
                            <div class="absolute top-20 -left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
                            <div class="absolute bottom-20 -right-20 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-pulse delay-700"></div>

                            <!-- Pattern overlay -->
                            <div class="absolute inset-0 opacity-10"
                                 style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

                            <div class="fixed z-10 flex items-start justify-center p-12">
                                <div class="max-w-lg w-full space-">
                                    <!-- Logo/Brand -->
                                    <div class="space-y-2">
                                        <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full border border-white/30">
                                            <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                                            <span class="text-white text-sm font-medium">Trusted by 10,000+ users</span>
                                        </div>
                                        <Link href="/" class="flex items-center justify-start text-5xl font-bold text-white tracking-tight">
                                            <div class="flex justify-center mb-8">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center mr-3">
                                                        <span class="text-secondary font-bold text-lg">P</span>
                                                    </div>
                                            Phixobel
                                                </div>
                                            </div>
                                        </Link>
                                    </div>

                                    <!-- Main headline -->
                                    <div class="space-y-4">
                                        <h2 class="text-4xl font-bold text-white leading-tight">
                                            Your everyday
                                            <span class="bg-gradient-to-r from-yellow-200 to-orange-200 bg-clip-text text-transparent">
                                    Marketplace
                                </span>
                                        </h2>
                                        <h3 class="text-2xl text-white/90 italic font-thin">
                                            Where trade happens.
                                        </h3>
                                        <p class="text-lg text-white/90">
                                            Connect with trusted vendors in your area. Buy and sell securely with confidence.
                                        </p>
                                    </div>

                                    <!-- Feature list with icons -->
                                    <div class="space-y-4 pt-4">
                                        <div class="flex items-start gap-4 group">
                                            <div class="flex-shrink-0 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/30 group-hover:scale-110 transition-transform">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-white font-semibold">Instant Setup</h3>
                                                <p class="text-white/80 text-sm">Start buying or selling in minutes</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-4 group">
                                            <div class="flex-shrink-0 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/30 group-hover:scale-110 transition-transform">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-white font-semibold">Secure Transactions</h3>
                                                <p class="text-white/80 text-sm">Meet, verify, and buy with peace of mind</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-4 group">
                                            <div class="flex-shrink-0 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/30 group-hover:scale-110 transition-transform">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-white font-semibold">24/7 Support</h3>
                                                <p class="text-white/80 text-sm">We're here whenever you need us</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

            <!-- Right login form -->
            <div class="flex-1 flex items-center justify-center p-6 lg:p-8">
                <div class="w-full max-w-md">
                    <!-- Mobile logo -->
                    <Link href="/" class="lg:hidden flex justify-center mb-8">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center mr-3">
                                <span class="text-white font-bold text-lg">P</span>
                            </div>
                            <h1 class="text-2xl font-bold text-slate-800">Phixobel</h1>
                        </div>
                    </Link>

                    <div class="text-center mb-10">
                        <h1 class="text-3xl font-bold text-slate-800 mb-2">Welcome Back</h1>
                        <p class="text-slate-600">Sign in to your account to continue buying and selling locally</p>
                    </div>

                    <div class="bg-white rounded-2xl p-8 shadow-xl border border-slate-100">
                        <!-- Social login options -->
<!--                        <div class="mb-6">-->
<!--                            <button class="w-full flex items-center justify-center gap-3 py-3 px-4 border border-slate-200 rounded-lg text-slate-700 font-medium hover:bg-slate-50 transition-colors">-->
<!--                                <svg class="w-5 h-5" viewBox="0 0 24 24">-->
<!--                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>-->
<!--                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>-->
<!--                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>-->
<!--                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>-->
<!--                                </svg>-->
<!--                                Continue with Google-->
<!--                            </button>-->
<!--                        </div>-->

                        <div class="relative mb-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-slate-200"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-slate-500">Login with email, username or phone</span>
                            </div>
                        </div>

                        <div v-if="message" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
                            {{ message }}
                        </div>

                        <form @submit.prevent="submit" class="space-y-5">
                            <div>
                                <InputLabel for="login" value="Email or Phone" class="mb-2" />
                                <TextInput
                                    id="login"
                                    type="text"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="Enter your email or phone number"
                                    v-model="form.login"
                                    required
                                    autofocus
                                />
                                <InputError :message="errors.login || errors.email" />
                            </div>

                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <InputLabel for="password" value="Password" />
                                    <a href="/forgot-password" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Forgot password?</a>
                                </div>
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="Enter your password"
                                    v-model="form.password"
                                    required
                                />
                                <InputError :message="errors.password" />
                            </div>

                            <div class="flex items-center">
                                <label class="flex items-center cursor-pointer">
                                    <Checkbox v-model:checked="form.remember" />
                                    <span class="ml-2 text-sm text-slate-700">Remember me for 30 days</span>
                                </label>
                            </div>

                            <PrimaryButton
                                class="w-full h-12 bg-gradient-to-r from-secondary to-primary hover:from-primary hover:to-secondary text-white font-semibold rounded-lg flex items-center justify-center shadow-md hover:shadow-lg transition-all"
                                :disabled="loading"
                            >
                                <span v-if="!loading">Sign In</span>
                                <span v-else class="flex items-center gap-2">
                                    <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" class="opacity-25" />
                                        <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z" class="opacity-75" />
                                    </svg>
                                    Signing In...
                                </span>
                            </PrimaryButton>
                        </form>

                        <div class="text-center pt-6 mt-6 border-t border-slate-200">
                            <p class="text-sm text-slate-600">
                                Don't have an account?
                                <a href="/register" class="text-blue-600 font-semibold hover:text-blue-800 ml-1">Join Phixobel</a>
                            </p>
                            <p class="text-xs text-slate-500 mt-2">Start selling and buying in your community today</p>
                        </div>
                    </div>

                    <!-- Trust indicators -->
                    <div class="mt-8 text-center">
                        <p class="text-xs text-slate-500 mb-4">Secure & trusted marketplace</p>
                        <div class="flex justify-center space-x-6">
                            <div class="flex items-center text-slate-400">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-xs">Secure</span>
                            </div>
                            <div class="flex items-center text-slate-400">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-xs">Verified</span>
                            </div>
                            <div class="flex items-center text-slate-400">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                                </svg>
                                <span class="text-xs">Local</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
.slide-enter-active,
.slide-leave-active {
    transition: all 0.5s ease;
}
.slide-enter-from {
    opacity: 0;
    transform: translateX(30px);
}
.slide-leave-to {
    opacity: 0;
    transform: translateX(-30px);
}
</style>
