<script setup>
import {ref} from 'vue'
import {useForm, Link} from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Modal from '@/Components/Modal.vue'

const notification = ref('')

defineProps({
    users: Array,
})

const showCreateModal = ref(false)
const showEditModal = ref(false)
const editingUser = ref(null)


const createForm = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 1
})

const editForm = useForm({
    id: null,
    name: '',
    email: '',
    role: 1,
})


function openEdit(user) {
    editingUser.value = user
    editForm.id = user.id
    editForm.name = user.name
    editForm.email = user.email
    editForm.role = user.role
    showEditModal.value = true
}


function submitCreate() {
    createForm.post(route('users.store'), {
        onSuccess: () => {
            showCreateModal.value = false
            createForm.reset()
            notification.value = 'Utilisateur créé avec succès !'
            setTimeout(() => notification.value = '', 3000)
        },
    })
}


function submitEdit() {
    editForm.put(route('users.update', editForm.id), {
        onSuccess: () => {
            showEditModal.value = false
            notification.value = 'Mise a jour avec succès !'
        },
    })
}

function deleteUser(user) {
    if (!confirm(`Voulez-vous vraiment supprimer ${user.name} ?`)) return;

    const form = useForm()
    form.delete(route('users.destroy', user.id), {
        onSuccess: () => {
            notification.value = `Utilisateur ${user.name} supprimé avec succès !`
            setTimeout(() => notification.value = '', 3000)
        },
    })
}

</script>

<template>
    <Head title="Users"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Listes utilisateur
            </h2>
        </template>
        <div v-if="notification" class="mb-4 p-2 bg-green-100 text-green-800 rounded">
            {{ notification }}
        </div>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <button @click="showCreateModal = true"
                                class="bg-blue-500 text-white px-4 py-2 rounded">
                            Ajouter un utilisateur
                        </button>

                        <table class="mt-4 w-full border">
                            <thead>
                            <tr>
                                <th class="border px-4 py-2">Nom</th>
                                <th class="border px-4 py-2">Email</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td class="border px-4 py-2">{{ user.name }}</td>
                                <td class="border px-4 py-2">{{ user.email }}</td>
                                <td class="border px-4 py-2">
                                    <button @click="openEdit(user)" class="text-blue-500">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button @click="deleteUser(user)" class="text-red-500 ml-2">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <Modal :show="showCreateModal" @close="showCreateModal = false">
            <template #title>Créer un utilisateur</template>

            <form @submit.prevent="submitCreate" class="space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input
                        v-model="createForm.name"
                        type="text"
                        placeholder="Entrez le nom"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                    <div v-if="createForm.errors.name" class="text-red-500 text-sm mt-1">
                        {{ createForm.errors.name }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input
                        v-model="createForm.email"
                        type="email"
                        placeholder="exemple@mail.com"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                    <div v-if="createForm.errors.email" class="text-red-500 text-sm mt-1">
                        {{ createForm.errors.email }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                    <input
                        v-model="createForm.password"
                        type="password"
                        placeholder="******"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                    <div v-if="createForm.errors.password" class="text-red-500 text-sm mt-1">
                        {{ createForm.errors.password }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirmation mot de passe</label>
                    <input
                        v-model="createForm.password_confirmation"
                        type="password"
                        placeholder="******"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                    <select
                        v-model="createForm.role"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                        <option :value="0">Admin</option>
                        <option :value="1">Client</option>
                    </select>
                </div>

                <button
                    type="submit"
                    :disabled="createForm.processing"
                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <i class="fa-solid fa-floppy-disk"></i> Sauvegarder
                </button>

            </form>
        </Modal>

        <Modal :show="showEditModal" @close="showEditModal = false">
            <template #title>Modifier utilisateur</template>

            <form @submit.prevent="submitEdit" class="space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input
                        v-model="editForm.name"
                        type="text"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                    <div v-if="editForm.errors?.name" class="text-red-500 text-sm mt-1">
                        {{ editForm.errors.name }}
                    </div>
                </div>


                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input
                        v-model="editForm.email"
                        type="email"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                    <div v-if="editForm.errors?.email" class="text-red-500 text-sm mt-1">
                        {{ editForm.errors.email }}
                    </div>
                </div>


                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 transition"
                >
                    <i class="fa-solid fa-pen-to-square"></i> Mettre a jour
                </button>
            </form>
        </Modal>

    </AuthenticatedLayout>
</template>
