<template>
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>Admin</b>Login</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <div class="alert alert-danger text-sm" v-if="errorMessage" role="alert">
                    {{ errorMessage }}
                </div>
                <form @submit.prevent="handleSubmit">
                    <div class="input-group mb-3">
                        <input v-model="form.email" type="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input v-model="form.password" type="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block" :disabled="loading">
                                <div v-if="loading" class="spinner-border spinner-border-sm text-light" role="status">
                                    <span class="visually-hidden"></span>
                                </div>
                                <span v-else>Login</span>
                            </button>
                        </div>
                    </div>
                </form>

                <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
            </div>
        </div>
    </div>
</template>
<script setup>
import axios from 'axios';
import { reactive, ref } from "vue";

    const errorMessage = ref('');
    const loading = ref(false);

    const form = reactive({
        email: '',
        password: '',
    });

    const handleSubmit = () => {
        loading.value = true;
        axios.post('/login', form)
        .then(() => {
            window.location.href='/admin/dashboard';
        })
        .catch((error) => {
            errorMessage.value = error.response.data.message;
        })
        .finally(() => {
            loading.value = false;
        })
    }
</script>
