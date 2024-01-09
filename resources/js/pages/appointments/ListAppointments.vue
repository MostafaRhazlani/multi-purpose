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
                            <router-link class="btn btn-primary" to="/admin/appointments/create">
                                <i class="nav-icon fas fa-plus-circle "></i>&nbsp;
                                Add
                            </router-link>
                        </div>
                        <div class="btn-group">
                            <button @click="getAppointments()" type="button" class="btn" :class="[selectedStatus ? 'btn-default' : 'btn-secondary']">
                                <span class="mr-1">ALL</span>
                                <span class="badge badge-pill badge-info">{{ appointmentCount }}</span>
                            </button>

                            <button v-for="(status, index) in appointmentStatus" :key="index" @click="getAppointments(status.value)" type="button" class="btn" :class="[selectedStatus === status.value ? 'btn-secondary' : 'btn-default']">
                                <span class="mr-1">{{ status.name }}</span>
                                <span class="badge badge-pill" :class="`badge-${status.color}`">{{ status.count }}</span>
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
                                    <router-link :to="`/admin/appointments/${appointment.id}/edit`" class="badge badge-primary">
                                        <i class="fa fa-edit"></i>
                                        Edit
                                    </router-link>
                                    &nbsp;&nbsp;
                                    <!-- button delete -->
                                    <a href="#" @click.prevent="deleteAppointment(appointment.id)" class="badge badge-danger">
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
import { onMounted, ref, computed } from "vue";
import Swal from 'sweetalert2'

    const appointmentStatus = ref([]);
    const getAppointmentStatus = () => {
        axios.get('/api/appointment-status')
        .then((response) => {
            appointmentStatus.value = response.data
        })
    }

    const selectedStatus = ref();
    const appointments = ref([]);
    const getAppointments = (status) => {
        const params = {};
        selectedStatus.value = status;


        if(status) {
            params.status = status;
        }
        axios.get('/api/appointments/', {params: params})
        .then((response) => {
            appointments.value = response.data
        })
    }

    const deleteAppointment = (id) => {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`/api/appointments/${id}`)
                .then((response) => {
                    appointments.value.data = appointments.value.data.filter(appointment => appointment.id !== id)
                    Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                    });
                })
            }
        });
    }

    const appointmentCount = computed(() => {
        return appointmentStatus.value.map(status => status.count).reduce((acc, value) => acc + value, 0);
    })

    onMounted(() => {
        getAppointments();
        getAppointmentStatus();
    })

</script>
