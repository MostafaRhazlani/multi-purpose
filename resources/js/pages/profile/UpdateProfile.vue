<template>
    <!-- content header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end content header -->

    <!-- content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="col border-top border-primary rounded-top">
                    <div class="mt-3">
                        <div class="col-12">
                            <div class="col-6 mx-auto d-flex flex-column align-items-center">
                                <input @change="handleFileChange" ref="fileInput" type="file" class="d-none">
                                    <img @click="openFileInput" :src="profilePictureUrl ? profilePictureUrl : form.avatar "
                                    class="profile-user-img rounded-circle"
                                    width="100"
                                    height="100"
                                    alt=""
                                    >
                                <span :class="form.role === 'admin' ? 'badge badge-success' : 'badge badge-danger'" class="mt-1">{{ form.role }}</span>
                                <h4 class="mt-2 mb-0">{{ form.name }}</h4>
                                <span>{{ form.email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form @submit.prevent="updateProfile()">
                        <div class="col">
                            <div class="col-12">
                                <div class="col-6 mx-auto">
                                    <div class="mb-2">
                                        <label for="changeName">Change Name</label>
                                        <input v-model="form.name" type="text" class="form-control" id="changeName">
                                        <span class="text-danger text-sm" v-if="errors && errors.name" >{{ errors.name[0] }}</span>
                                    </div>
                                    <div class="mb-4">
                                        <label for="changeEmail">Change Email</label>
                                        <input v-model="form.email" type="text" class="form-control" id="changeEmail">
                                        <span class="text-danger text-sm" v-if="errors && errors.email" >{{ errors.email[0] }}</span>
                                    </div>
                                    <button class="btn btn-primary w-100">Save</button>

                                    <div class="mt-3 d-flex">
                                        <p>I forget my password:</p>
                                        <a href="#" class="ml-2 text-secondary">
                                            <i class="fas fa-key "></i>
                                            Change Password
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end content -->
</template>

<script setup>

import axios from 'axios'
import { onMounted, ref } from 'vue';
import { useToastr } from '@/toastr.js';

    const toastr = useToastr();

    const form = ref({
        name: '',
        email: '',
        role: '',
    });
    const errors = ref();

    const getUser = () => {
        axios.get('/api/profile')
        .then((response) => {
           form.value = response.data
        });
    }

    const updateProfile = () => {
        errors.value = '';
        axios.put('/api/profile', form.value)
        .then((response) => {
            toastr.success('Profile updated successfully')
        })
        .catch((error) => {
            if(error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        })
    }

    const fileInput = ref(null);


    const openFileInput = () => {
        fileInput.value.click();
    }

    const profilePictureUrl = ref(null);

    const handleFileChange = (event) => {
        const file = event.target.files[0];
        profilePictureUrl.value = URL.createObjectURL(file);

        const formData = new FormData();
        formData.append('profile_picture', file);

        axios.post('/api/upload-profile-image', formData)
        .then((response) => {
            toastr.success('profile uploaded successfully');
        })
    }

    onMounted(() => {
        getUser();
    });
</script>

<style>
    .profile-user-img:hover {
        background-color: #0069D9;
        cursor: pointer;
    }
</style>
