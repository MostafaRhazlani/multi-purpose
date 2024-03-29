<script setup>
    import axios from 'axios';
    import { ref, onMounted, watch } from 'vue';

    import {Form, Field} from 'vee-validate';
    import * as yup from 'yup';
    import debounce from 'lodash/debounce';
    import { useToastr } from '../../toastr.js';
    import UserListItem from './UserListItem.vue';
    import { Bootstrap5Pagination } from 'laravel-vue-pagination';

    const users = ref({'data': []});
    const editing = ref(false);
    const toastr = useToastr();
    const form = ref(null);
    const searchQuery = ref(null);

    // function for get users
    const getUsers = (page = 1) => {
        axios.get(`/api/users?page=${page}`, {
            params: {
                query: searchQuery.value
            }
        })
        .then((response) => {
            users.value = response.data;
            userSelected.value = [];
            selectAll.value = false;
        })
    }

    // function of create user
    const createUser = (values, { resetForm,  setErrors}) => {

        axios.post('/api/users', values)
        .then((response) => {
            users.value.data.unshift(response.data);
            $('#userFormModal').modal('hide');
            resetForm();
            toastr.success('User created successfully');
            getUsers()
        })

        .catch((error) => {
            if(error.response.data.errors) {
                setErrors(error.response.data.errors);
            }
        })
    }

    // function for update user
    const updateUser = (values, { setErrors }) => {
        axios.put('/api/users/' + values.id, values)
        .then((response) => {
            const index = users.value.data.findIndex(user => user.id === response.data.id);
            users.value.data[index] =response.data;
            $('#userFormModal').modal('hide');
            toastr.success('User updated successfully');
            getUsers()
        }).catch((error) => {
            setErrors(error.response.data.errors);
        });
    }

    // function for show modal edit user and get data of user
    const editUser = (user) => {
        form.value.resetForm();
        editing.value = true;
        form.value.setValues({
            id: user.id,
            name: user.name,
            email: user.email,
        })
        $('#userFormModal').modal('show');
    }

    const userDeleted = (userId) => {
        users.value.data = users.value.data.filter(user => user.id !== userId);
    }

    // function for differentiates between submit updateUser and submit createUser
    const handleSubmit = (values, actions) => {
        if(editing.value) {
            updateUser(values, actions)
        } else {
            createUser(values, actions)
        }
    }

    // function for show modal add user
    const addUser = () => {
        form.value.resetForm();
        editing.value = false;
        $('#userFormModal').modal('show');
    }



    // Auto search
    watch(searchQuery, debounce(() => {
        getUsers();
    }, 500))

    const userSelected = ref([]);

    const toggleSelection = (user) => {

        const index = userSelected.value.indexOf(user.id);

        if(index === -1) {
            userSelected.value.push(user.id);
        } else {
            userSelected.value.splice(index, 1);
        }
    }

    const bulkDelete = () => {
        axios.delete('/api/users', {
            data: {
                ids: userSelected.value
            }
        })
        .then(response => {
            getUsers();
            userSelected.value = [];
            selectAll.value = false;
            toastr.success(response.data.message);
        })
    }


    const selectAll = ref(false);
    const selectAllUsers = () => {
        if(selectAll.value) {
            userSelected.value = users.value.data.map(user => user.id)
        } else {
            userSelected.value = [];
        }
    }

    // validation for create
    const createUserSchema =  yup.object({
        name: yup.string().required(),
        email: yup.string().email().required(),
        password: yup.string().required().min(8),
    });

    // validation for edit
    const editUserSchema =  yup.object({
        name: yup.string().required(),
        email: yup.string().email().required(),
        password: yup.string().min(8),
    });

    onMounted(() => {
        getUsers();
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
                <div class="d-flex justify-content-between" >
                    <div class="mt-3 ml-3">
                        <button @click="addUser" type="button" class="btn btn-primary btn-sm">
                            <i class="nav-icon fas fa-plus-circle "></i>&nbsp;
                            Add user
                        </button>
                        <button v-if="userSelected.length > 0" @click="bulkDelete" type="button" class="ml-2 btn btn-danger btn-sm">
                            <i class="nav-icon fas fa-trash"></i>&nbsp;
                            Delete selected
                            <span class="ml-1">{{ userSelected.length }}</span>
                        </button>
                    </div>
                    <div class="mr-3 mt-3">
                        <input type="search" v-model="searchQuery" class="form-control form-control-sm" placeholder="Serach...">
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover text-center">
                        <thead>
                            <tr>
                            <th scope="col"><input type="checkbox" v-model="selectAll" @change="selectAllUsers" /></th>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Registered Date</th>
                            <th scope="col">Role</th>
                            <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody v-if="users.data.length > 0">
                            <UserListItem v-for="(user, index) in users.data"
                                :key="user.id"
                                :user=user
                                :index=index
                                :select-all="selectAll"
                                @user-deleted="userDeleted"
                                @edit-user="editUser"
                                @toggle-selection="toggleSelection"

                            />
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="7" class="text-center">No results found...</td>
                            </tr>
                        </tbody>
                    </table>
                    <Bootstrap5Pagination class="mb-0 mt-4"
                        :data="users"
                        @pagination-change-page="getUsers"
                    />
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="userFormModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5 text-bold" id="exampleModalLabel">
                        <span v-if="editing">Edit User</span>
                        <span v-else>Add New User</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <Form ref="form" @submit="handleSubmit" :validation-schema="editing ? editUserSchema : createUserSchema" v-slot="{ errors }">
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
