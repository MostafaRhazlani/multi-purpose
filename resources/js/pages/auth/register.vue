<template>
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/login" class="h1"><b>Admin </b>Sign in</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign up to get your account</p>
                <div class="alert alert-danger text-sm" v-if="errorMessage" role="alert">
                  {{ errorMessage }}
                </div>
                <form @submit.prevent="handleSubmit()">
                    <div class="input-group mb-3">
                        <input v-model="form.name" type="text" class="form-control" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
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
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">
                                <span>Sign up</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup>

import axios from 'axios';
import { reactive, ref } from 'vue';
import { useToastr } from '@/toastr.js';

    const toastr = useToastr();
    const errorMessage = ref('');

    const form = reactive({
        'name': '',
        'email': '',
        'password': '',
    });

    const handleSubmit = () => {
        axios.post('/api/register', form)
        .then((response) => {
            toastr.success('Registred successfully');
            errorMessage.value = '';
            for(const field in form) {
                form[field] = '';
            }
        })
        .catch((error) => {
            errorMessage.value = error.response.data.message
        })
    }

</script>
