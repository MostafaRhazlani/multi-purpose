<template>
    <!-- content header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Appointments</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Appointments</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end content header -->

    <!-- content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-primary">
                                <i class="nav-icon fas fa-plus-circle "></i>&nbsp;
                                Add
                            </button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary">
                                <span class="mr-1">All</span>
                                <span class="badge badge-pill badge-info">1</span>
                            </button>

                            <button type="button" class="btn btn-default">
                                <span class="mr-1">Scheduled</span>
                                <span class="badge badge-pill badge-primary">0</span>
                            </button>

                            <button type="button" class="btn btn-default">
                                <span class="mr-1">Closed</span>
                                <span class="badge badge-pill badge-success">1</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-hover text-center mt-3">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Client name</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Status</th>
                            <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(appointment, index) in appointments.data" :key="appointment.id">
                                <th scope="row">{{ index +1 }}</th>
                                <td>{{ appointment.client.first_name }} {{ appointment.client.last_name }}</td>
                                <td>{{ appointment.start_time }}</td>
                                <td>{{ appointment.end_time }}</td>
                                <td>
                                    <span class="badge badge-pill" :class="`badge-${appointment.status.color}`">{{ appointment.status.name }}</span>
                                </td>
                                <td>
                                    <!-- button edit -->
                                    <a href="#" class="badge badge-primary">
                                        <i class="fa fa-edit"></i>
                                        Edit
                                    </a>
                                    &nbsp;&nbsp;
                                    <!-- button delete -->
                                    <a href="#" class="badge badge-danger">
                                        <i class="fa fa-trash"></i>
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";

const appointments = ref([]);


    const getAppointments = () => {
        axios.get('/api/appointments/')
        .then((response) => {
            appointments.value = response.data
        })
    }

    onMounted(() => {
        getAppointments();
    })

</script>
