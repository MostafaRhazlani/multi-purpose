<template>
    <!-- content header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Settings</li>
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

                <div class="card-body">
                    <form @submit.prevent="updateSettings()">
                        <div class="mb-3">
                            <label for="pageName" class="form-label">Page Name</label>
                            <input v-model="setting.page_name" type="text" class="form-control" id="pageName" placeholder="page name">
                        </div>
                        <div class="mb-3">
                            <label for="dateFormat" class="form-label">Date Format</label>
                            <select v-model="setting.date_format" id="dateFormat" class="form-control">
                                <option value="MM/DD/YYYY">MM/DD/YYYY</option>
                                <option value="YYYY-DD-MM">YYYY-DD-MM</option>
                                <option value="YY/DD/MM">YY/DD/MM</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="paginationLimit" class="form-label">Pagination Limit</label>
                            <input v-model="setting.pagination_limit" type="text" class="form-control" id="paginationLimit">
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end content -->
</template>

<script setup>
import axios from 'axios';
import { onMounted, ref } from "vue";
import { useToastr } from '@/toastr';

    const toastr = useToastr();
    const setting = ref([]);

    const getSettings = () => {
        axios.get('/api/settings')
        .then((response) => {
            setting.value = response.data
        })
    }

    const updateSettings = () => {
        axios.post('/api/settings', setting.value)
        .then((response) => {
            toastr.success('Settings changed successfuly');
        });
    }

    onMounted(() => {
        getSettings();
    });

</script>
