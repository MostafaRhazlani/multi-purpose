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
                            <span class="text-danger text-sm" v-if="errors && errors.page_name">{{ errors.page_name[0] }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="dateFormat" class="form-label">Date Format</label>
                            <select v-model="setting.date_format" id="dateFormat" class="form-control">
                                <optgroup label="-">
                                    <option value="m-d-Y">MM-DD-YYYY</option>
                                    <option value="Y-d-m">YYYY-DD-MM</option>
                                    <option value="y-d-m">YY-DD-MM</option>
                                    <option value="m-d-y">MM-DD-YY</option>
                                </optgroup>

                                <optgroup label="/">
                                    <option value="m/d/Y">MM/DD/YYYY</option>
                                    <option value="Y/d/m">YYYY/DD/MM</option>
                                    <option value="y/d/m">YY/DD/MM</option>
                                    <option value="m/d/y">MM/DD/YY</option>
                                </optgroup>

                                <optgroup label="string">
                                    <option value="F j, Y">Month DD, YYYY</option>
                                    <option value="j F Y">Day Month YYYY</option>
                                    <option value="F d Y">Month DD YYYY</option>
                                    <option value="d F Y">DD Month YYYY</option>
                                </optgroup>
                            </select>
                            <span class="text-danger text-sm" v-if="errors && errors.date_format">{{ errors.date_format[0] }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="paginationLimit" class="form-label">Pagination Limit</label>
                            <input v-model="setting.pagination_limit" type="text" class="form-control" id="paginationLimit">
                            <span class="text-danger text-sm" v-if="errors && errors.pagination_limit">{{ errors.pagination_limit[0] }}</span>
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
    const errors = ref();

    const getSettings = () => {
        axios.get('/api/settings')
        .then((response) => {
            setting.value = response.data
        })
    }

    const updateSettings = () => {
        errors.value = '';
        axios.post('/api/settings', setting.value)
        .then((response) => {
            toastr.success('Settings changed successfuly');
        })
        .catch((error) => {
            if(error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        });
    }

    onMounted(() => {
        getSettings();
    });

</script>
