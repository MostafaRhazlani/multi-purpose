<script setup>
    import axios from 'axios';
    import { ref, onMounted } from 'vue';

    import {Form, Field} from 'vee-validate';
    import * as yup from 'yup';

    const users = ref([]);

    const getUsers = () => {
        axios.get('/api/users')
        .then((response) => {
            users.value = response.data;
        })
    }

    const createUser = (values, { resetForm }) => {
        console.log(values);
        axios.post('/api/users', values)
        .then((response) => {
            users.value.unshift(response.data);
            $('#createUserModal').modal('hide');
            resetForm();
        });
    }

    const schema =  yup.object({
        name: yup.string().required(),
        email: yup.string().email().required(),
        password: yup.string().required().min(8),
    });

    onMounted(() => {
        getUsers()
    })
</script>

<template>
    <!-- content header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                <div class="mt-3 ml-3">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createUserModal">
                        <i class="nav-icon fas fa-plus"></i>&nbsp;
                        Add User
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover text-center">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Registered Date</th>
                            <th scope="col">Role</th>
                            <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, index) in users" :key="user.id">
                                <th scope="row">{{ index + 1 }}</th>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>-</td>
                                <td>Admin</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5 text-bold" id="exampleModalLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <Form @submit="createUser" :validation-schema="schema" v-slot="{ errors }">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label text-danger">Name *</label>
                            <Field name="name" type="text" class="form-control" :class="{'is-invalid' : errors.name}" id="name" placeholder="Enter your name" />
                            <span class="invalid-feedback">{{ errors.name }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-danger">Email *</label>
                            <Field name="email" type="email" class="form-control" :class="{'is-invalid' : errors.email}" id="email" placeholder="Enter your email" />
                            <span class="invalid-feedback">{{ errors.email }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label text-danger">Password *</label>
                            <Field name="password" type="password" class="form-control" :class="{'is-invalid' : errors.password}" id="password" />
                            <span class="invalid-feedback">{{ errors.password }}</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-sm">Save</button>
                    </div>
                </Form>
            </div>
        </div>
    </div>
</template>
