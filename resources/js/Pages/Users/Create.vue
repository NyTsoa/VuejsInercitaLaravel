<script setup>

</script>

<template>
    <h1>creation</h1>
    <Modal :show="showCreateModal" @close="showCreateModal = false">
        <template #title>Créer utilisateur</template>
        <form @submit.prevent="submitCreate">
            <div class="mb-2">
                <label>Nom</label>
                <input v-model="createForm.name" class="border rounded w-full px-2 py-1"/>
            </div>
            <div class="mb-2">
                <label>Email</label>
                <input v-model="createForm.email" type="email" class="border rounded w-full px-2 py-1"/>
            </div>
            <div class="mb-2">
                <label>Mot de passe</label>
                <input v-model="createForm.password" type="password" class="border rounded w-full px-2 py-1"/>
            </div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                Sauvegarder
            </button>
        </form>
    </Modal>
</template>

<style scoped>

</style>
