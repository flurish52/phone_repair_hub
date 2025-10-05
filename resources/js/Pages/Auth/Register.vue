<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <div class="flex min-h-screen">
            <!-- Left image side -->
            <div class="w-1/2 hidden md:flex items-center justify-center bg-secondary">
                <img
                    src="https://i.pinimg.com/736x/86/89/9d/86899df435a469690f7230684792299b.jpg"
                    alt="Phone repair"
                    class="w-full h-full object-cover"
                />
            </div>

            <!-- Right register form side -->
            <div class="w-flex items-start justify-center bg-primary p-8">
                <div class="w-full max-w-md">
                    <div class="w-full mb-6">
                        <h1 class="text-3xl font-bold text-secondary mb-2">Register</h1>
                        <p class="text-secondary text-sm leading-relaxed">
                            Keep track of every device, log repairs quickly, and manage pick-ups with ease.
                        </p>
                    </div>

                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <InputLabel for="name" value="Name" class="text-secondary" />
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-secondary"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div>
                            <InputLabel for="email" value="Email" class="text-secondary" />
                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-secondary"
                                v-model="form.email"
                                required
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
                                autocomplete="new-password"
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div>
                            <InputLabel for="password_confirmation" value="Confirm Password" class="text-secondary" />
                            <TextInput
                                id="password_confirmation"
                                type="password"
                                class="mt-1 block w-full border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-secondary"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                            />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>

                        <div class="mt-4 flex items-center justify-end space-x-4">
                            <Link
                                :href="route('login')"
                                class="rounded-md text-sm text-secondary underline hover:bg-secondary hover:text-primary px-1 transition-colors duration-300"
                            >
                                Already registered?
                            </Link>

                            <PrimaryButton
                                class="ms-4 bg-secondary text-primary hover:bg-primary hover:text-secondary hover:border hover:border-secondary transition-colors duration-300"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Register
                            </PrimaryButton>
                        </div>
                    </form>
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

