<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    login: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="flex h-screen overflow-hidden bg-slate-50">

            <div class="hidden lg:flex lg:flex-1 relative bg-gradient-to-br from-[#536b7b] to-[#3a4d5a] overflow-hidden">
                <img
                    src="https://i.pinimg.com/736x/86/89/9d/86899df435a469690f7230684792299b.jpg"
                    alt="Phone repair"
                    class="w-full h-full object-cover opacity-30"
                />
                <!-- Overlay gradient -->
                <div class="absolute inset-0 bg-gradient-to-br from-[#536b7b]/80 to-[#3a4d5a]/80"></div>

                <!-- Content overlay -->
                <div class="absolute inset-0 flex items-center justify-center p-8">
                    <div class="relative z-10 max-w-lg w-full text-[#fdfdf7]">
                        <!-- Logo and brand -->
                        <div class="flex items-center mb-12">
                            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mr-4 backdrop-blur-sm">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 0C8.954 0 0 8.954 0 20C0 31.046 8.954 40 20 40C31.046 40 40 31.046 40 20C40 8.954 31.046 0 20 0ZM20 36C11.178 36 4 28.822 4 20C4 11.178 11.178 4 20 4C28.822 4 36 11.178 36 20C36 28.822 28.822 36 20 36Z" fill="#FDFDF7"/>
                                    <path d="M20 8C13.373 8 8 13.373 8 20C8 26.627 13.373 32 20 32C26.627 32 32 26.627 32 20C32 13.373 26.627 8 20 8ZM20 28C17.791 28 16 26.209 16 24C16 21.791 17.791 20 20 20C22.209 20 24 21.791 24 24C24 26.209 22.209 28 20 28Z" fill="#FDFDF7"/>
                                    <path d="M26 14C24.895 14 24 14.895 24 16C24 17.105 24.895 18 26 18C27.105 18 28 17.105 28 16C28 14.895 27.105 14 26 14Z" fill="#FDFDF7"/>
                                </svg>
                            </div>
                            <h1 class="text-3xl font-bold">PhixoBel</h1>
                        </div>

                        <!-- Main text -->
                        <div class="mb-10">
                            <h2 class="text-4xl font-bold mb-4 leading-tight">Start Managing Your Repairs</h2>
                            <p class="text-lg opacity-90 leading-relaxed">Join hundreds of repair shops using DeviceFlow to streamline their operations and delight their customers.</p>
                        </div>

                        <!-- Features -->
                        <div class="flex flex-col gap-5">
                            <div class="flex items-center">
                                <div class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center mr-4 backdrop-blur-sm flex-shrink-0">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM8 15L3 10L4.41 8.59L8 12.17L15.59 4.58L17 6L8 15Z" fill="#FDFDF7"/>
                                    </svg>
                                </div>
                                <span class="text-base">No setup required</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center mr-4 backdrop-blur-sm flex-shrink-0">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM8 15L3 10L4.41 8.59L8 12.17L15.59 4.58L17 6L8 15Z" fill="#FDFDF7"/>
                                    </svg>
                                </div>
                                <span class="text-base">Secure and reliable</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center mr-4 backdrop-blur-sm flex-shrink-0">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM8 15L3 10L4.41 8.59L8 12.17L15.59 4.58L17 6L8 15Z" fill="#FDFDF7"/>
                                    </svg>
                                </div>
                                <span class="text-base">24/7 customer support</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right login form -->
            <div class="flex-1 flex items-center justify-center p-6 lg:p-8 overflow-y-auto">
                <div class="w-full max-w-md">
                    <!-- Form header -->
                    <div class="mb-8 text-center lg:mb-10">
                        <h1 class="text-3xl lg:text-4xl font-bold text-slate-800 mb-2">Welcome Back</h1>
                        <p class="text-slate-600">Sign in to your account to continue</p>
                    </div>

                    <!-- Form content -->
                    <div class="bg-white rounded-2xl p-8 lg:p-10 shadow-xl border border-slate-200">
                        <!-- Status message -->
                        <div v-if="status" class="mb-6 p-3 bg-emerald-100 text-emerald-800 rounded-lg text-sm border border-emerald-200">
                            {{ status }}
                        </div>

                        <!-- Login form -->
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Email/Phone input -->
                            <div class="space-y-2">
                                <InputLabel for="login" value="Email or Phone" class="text-sm font-medium text-gray-700" />
                                <TextInput
                                    id="login"
                                    type="text"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base transition-all bg-gray-50 focus:bg-white focus:outline-none focus:ring-3 focus:ring-[#536b7b]/20 focus:border-[#536b7b]"
                                    v-model="form.login"
                                    required
                                    autofocus
                                    autocomplete="username"
                                />
                                <InputError class="text-sm text-red-600 mt-2" :message="form.errors.login" />
                            </div>

                            <!-- Password input -->
                            <div class="space-y-2">
                                <InputLabel for="password" value="Password" class="text-sm font-medium text-gray-700" />
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base transition-all bg-gray-50 focus:bg-white focus:outline-none focus:ring-3 focus:ring-[#536b7b]/20 focus:border-[#536b7b]"
                                    v-model="form.password"
                                    required
                                    autocomplete="current-password"
                                />
                                <InputError class="text-sm text-red-600 mt-2" :message="form.errors.password" />
                            </div>

                            <!-- Remember me and forgot password -->
                            <div class="flex items-center justify-between pt-2">
                                <label class="flex items-center cursor-pointer">
                                    <Checkbox name="remember" v-model:checked="form.remember" />
                                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                                </label>

                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="text-sm text-[#536b7b] hover:text-[#3a4d5a] hover:underline transition-colors"
                                >
                                    Forgot password?
                                </Link>
                            </div>

                            <!-- Submit button -->
                            <PrimaryButton
                                class="w-full h-12 bg-[#536b7b] hover:bg-[#3a4d5a] text-white font-semibold rounded-lg transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#536b7b]/20 disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none flex items-center justify-center"
                                :class="{ 'bg-gray-400 hover:bg-gray-400': form.processing }"
                                :disabled="form.processing"
                            >
                                <span v-if="!form.processing">Sign In</span>
                                <span v-else class="flex items-center gap-2">
                                    <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" stroke-linecap="round" class="opacity-25" />
                                        <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" class="opacity-75" />
                                    </svg>
                                    Signing In...
                                </span>
                            </PrimaryButton>

                            <!-- Register link -->
                            <div class="text-center pt-6 mt-6 border-t border-gray-200">
                                <p class="text-sm text-gray-600">
                                    Don't have an account?
                                    <Link href="/register" class="text-[#536b7b] font-medium hover:underline ml-1">
                                        Create one
                                    </Link>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
.bg-radial-gradient {
    background: radial-gradient(circle, rgba(253, 253, 247, 0.1) 0%, rgba(83, 107, 123, 0) 70%);
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
