<template>
    <!-- content header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Appointments</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item"><router-link to="/admin/appointments">Appointments</router-link></li>
                        <li class="breadcrumb-item active">Create</li>
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
                    <Form @submit="handleSubmit" v-slot:default="{ errors }">
                        <div class="mb-3 d-flex">
                            <div class="col col-6">
                                <label for="title" class="form-label">Title</label>
                                <input v-model="form.title" type="text" :class="{'is-invalid' : errors.title}" class="form-control form-control-lg" id="title" placeholder="">
                                <span class="invalid-feedback">{{ errors.title }}</span>
                            </div>
                            <div class="col col-6">
                                <label for="client_name" class="form-label">Client name</label>
                                <select v-model="form.client_id" id="client_name" :class="{'is-invalid' : errors.client_id}" class="form-control form-control-lg">
                                    <option :value="client.id" v-for="client in clients" :key="client.id">{{ client.first_name }} {{ client.last_name }}</option>
                                </select>
                                <span class="invalid-feedback">{{ errors.client_id }}</span>
                            </div>
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="col col-6">
                                <label for="start_time" class="form-label">Start time</label>
                                <input v-model="form.start_time" type="text" class="form-control form-control-lg flatpickr" :class="{'is-invalid': errors.start_time}" id="start_time" placeholder="">
                                <span class="invalid-feedback">{{ errors.start_time }}</span>
                            </div>
                            <div class="col col-6">
                                <label for="end_time" class="form-label">End time</label>
                                <input v-model="form.end_time" type="text" class="form-control form-control-lg flatpickr" :class="{'is-invalid': errors.end_time}" id="end_time" placeholder="">
                                <span class="invalid-feedback">{{ errors.end_time }}</span>
                            </div>
                        </div>
                        <div class="mb-4 col-12">
                            <label for="desc" class="form-label">Description</label>
                            <textarea v-model="form.description" :class="{'is-invalid' : errors.description}" class="form-control" id="desc" rows="4"></textarea>
                            <span class="invalid-feedback">{{ errors.description }}</span>

                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, reactive, ref } from "vue";
import { useRouter } from 'vue-router';
import { useToastr } from '@/toastr';
import { Form } from 'vee-validate';
import flatpickr from "flatpickr";
import 'flatpickr/dist/themes/dark.css';

const router = useRouter();
const toastr = useToastr();
const clients = ref();

    const form = reactive({
        'title': '',
        'client_id': '',
        'start_time': '',
        'end_time': '',
        'description': '',
    });

    const getclients = () => {
        axios.get('/api/clients')
        .then((response) => {
            clients.value = response.data
        })
    }

    const handleSubmit = (values, actions) => {
        axios.post('/api/appointments/create', form)
        .then((response) => {
            router.push('/admin/appointments');
            toastr.success('Appointment created successfully').css("width","500px");
        })
        .catch((error) => {
            actions.setErrors(error.response.data.errors);
        })
    };

    onMounted(() => {
        flatpickr('.flatpickr', {
            enableTime: true,
            dateFormat: 'Y-m-d h:i K',
            defaultHour: 8,
        });

        getclients();
    });

</script>
