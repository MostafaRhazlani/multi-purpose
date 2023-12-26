<template>
    <tr>
        <th scope="row">{{ index + 1 }}</th>
        <td>{{ user.name }}</td>
        <td>{{ user.email }}</td>
        <td>{{ formatDate(user.created_at) }}</td>
        <td>
            <select class="form-control form-control-sm" @change="changeRole(user, $event.target.value)">
                <option :selected="user.role === role.name" v-for="(role, index) in roles" :value="role.value" :key="index">{{ role.name }}</option>
            </select>
        </td>
        <td>
            <!-- button edit -->
            <a href="#" class="badge badge-primary" @click.prevent="$emit('editUser', user)">
                <i class="fa fa-edit"></i>
                Edit
            </a>
            &nbsp;&nbsp;
            <!-- button delete -->
            <a href="#" class="badge badge-danger" @click.prevent="confirmDelete(user)">
                <i class="fa fa-trash"></i>
                Delete
            </a>
        </td>
    </tr>

    <!-- Modal Delete User -->
    <div class="modal fade" id="userDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5 text-bold" id="exampleModalLabel">
                        <span>Delete User</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="text-danger mb-3">Are you sure you want to delete:</h4>
                    <Form ref="formDelete">
                        <div class="mb-3">
                            <Field name="name" type="text" class="form-control" readonly/>
                        </div>
                        <div class="mb-3">
                            <Field name="email" type="email" class="form-control" readonly/>
                        </div>
                    </Form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" @click.prevent="deleteUser" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

    import {Form, Field} from 'vee-validate';
    import { formatDate } from '../../helper.js';
    import { ref } from 'vue';
    import { useToastr } from '../../toastr.js';

    defineProps({
        user: Object,
        index: Number,
    });

    const emit = defineEmits(['userDeleted', 'editUser']);
    const userIdBeingDeleted = ref(null)
    const formDelete = ref(null);
    const toastr = useToastr();


    // Confirm delete
    const confirmDelete = (user) => {
        userIdBeingDeleted.value = user.id;
        formDelete.value.setValues({
            name: user.name,
            email: user.email,
        })
        $('#userDeleteModal').modal('show');
    }

    // function delete user
    const deleteUser = () => {
        axios.delete(`/api/users/${userIdBeingDeleted.value}`)
        .then(() => {
            $('#userDeleteModal').modal('hide');
            emit('userDeleted', userIdBeingDeleted.value);
            toastr.success('User Deleted successfully');
        })
    };

    // change role
    const changeRole = (user, role) => {
        axios.patch(`/api/users/${user.id}/change-role`, {
            role: role,
        })
        .then(() => {
            toastr.success('Role changed successfully')
        })
    }

    const roles = ref([
        {
            name: 'admin',
            value: 1
        },

        {
            name: 'user',
            value: 2
        }
    ]);
</script>
