<template>
    <!-- content header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end content header -->

    <!-- content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <div class="d-flex justify-content-between">
                                <h3>{{ totalAppointmentCount }}</h3>
                                <select
                                    @change="getAppointmentStatus()"
                                    v-model="selectedAppointmentStatus"
                                    style="height: 2rem; outline: 2px solid transparent;" class="px-1 rounded border-0">
                                    <option value="all">All</option>
                                    <option value="scheduled">Scheduled</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <p>Appointments</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <router-link to="/admin/appointments" class="small-box-footer">
                            View Appointments
                            <i class="fas fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>

                <div class="col-lg-6 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <div class="d-flex justify-content-between">
                                <h3>{{ totalUsersCount }}</h3>
                                <select
                                    @change="getUsersDateRange()"
                                    v-model="selectedUserDateRange"
                                    style="height: 2rem; outline: 2px solid transparent;" class="px-1 rounded border-0">
                                    <option value="today">Today</option>
                                    <option value="30_days">30 days</option>
                                    <option value="60_days">60 days</option>
                                    <option value="360_days">360 days</option>
                                    <option value="month_to_date">Month to Date</option>
                                    <option value="year_to_date">Year to Date</option>
                                </select>
                            </div>
                            <p>Users</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <router-link to="/admin/users" class="small-box-footer">
                            View Users
                            <i class="fas fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end content -->
</template>

<script setup>

import axios from 'axios';
import { onMounted, ref } from 'vue';

const selectedAppointmentStatus = ref('all');
const totalAppointmentCount = ref(0);

    const getAppointmentStatus = () => {
        axios.get('/api/status/appointments', {
            params: {
                status: selectedAppointmentStatus.value
            }
        })
        .then((response) => {
            totalAppointmentCount.value = response.data.totalAppointmentCount;
        })
    }

const selectedUserDateRange = ref('today');
const totalUsersCount = ref(0);

    const getUsersToday = () => {
        axios.get('/api/users/status', {
            params: {
                dateRange: selectedUserDateRange.value = 'today',
            }
        })
        .then((response) => {
            totalUsersCount.value = response.data.totalUsersCount;
        })
    }

    const getUsersDateRange = () => {
        axios.get('/api/users/status', {
            params: {
                dateRange: selectedUserDateRange.value,
            }
        })
        .then((response) => {
            totalUsersCount.value = response.data.totalUsersCount;
        })
    }

    onMounted(() => {
        getAppointmentStatus();
        if(selectedUserDateRange === 'today') {
            getUsersToday();
        } else {
            getUsersDateRange();    
        }
    });

</script>
