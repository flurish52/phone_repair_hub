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
    email: '',
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

        <div class="flex min-h-screen  items-start">
            <!-- Left image side -->
            <div class="w-1/2 hidden md:flex items-center justify-center bg-secondary">
                <img
                    src="https://i.pinimg.com/736x/86/89/9d/86899df435a469690f7230684792299b.jpg"
                    alt="Phone repair"
                    class="w-full h-full object-cover"
                />
            </div>

            <!-- Right login form side -->
            <div class="flex flex-col items-center justify-center p-8 ">
                <div class="w-full mb-6">
                    <h1 class="text-3xl font-bold text-secondary mb-2">Login</h1>
                    <p class="text-secondary text-sm leading-relaxed">
                        Keep track of every device, log repairs quickly, and manage pick-ups with ease.
                    </p>
                </div>

                <div class="w-full flex   bg-primary">
                <div class="w-full max-w-md">
                    <div v-if="status" class="mb-4 text-sm font-medium text-secondary">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <InputLabel for="email" value="Email" class="text-secondary" />

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-secondary"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                            />

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div>
                            <InputLabel for="password" value="Password" class="text-secondary" />

                            <TextInput
                                id="password"
                                type="password"
                                class="mt-1 block w-full border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-secondary"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                            />

                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="flex items-center mt-4">
                            <label class="flex items-center">
                                <Checkbox name="remember" v-model:checked="form.remember" />
                                <span class="ms-2 text-sm text-secondary">Remember me</span>
                            </label>
                        </div>

                        <div class="mt-4 flex items-center justify-end space-x-4">
                            <div class="flex">
                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="rounded-md text-sm text-secondary underline hover:bg-secondary hover:text-primary px-1 transition-colors duration-300"
                            >
                                Forgot your password?
                            </Link>

                            <div>
                                <p>Don't have account yet? <Link class="text-blue-500" href="/register">Register</Link> </p>
                            </div>

                            </div>
                            <PrimaryButton
                                class="ms-4 bg-secondary text-primary hover:bg-primary hover:text-secondary hover:border hover:border-secondary transition-colors duration-300"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Log in
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>

    </GuestLayout>
</template>

<style>
.bg-primary {
    background-color: #fdfdf7;
}
.bg-secondary {
    background-color: #536b7b;
}
.text-primary {
    color: #fdfdf7;
}
.text-secondary {
    color: #536b7b;
}
</style>

