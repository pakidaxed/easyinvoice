<template>
    <div>
        <label>
            <select name="client" @change="getClient(clientId)" v-model="clientId" required>
                <option value="0" :disabled="clientId !== 0">Please select client</option>
                <option v-for="client in clients" :key="client.id" :value="client.id">{{ client.name }}</option>
            </select>
        </label>
        <div v-if="clientSelected">
            <p class="m-0 font-weight-bold">{{ clientSelected.name }}</p>
            <p class="m-0">Company code: {{ clientSelected.code }}</p>
            <p class="m-0">VAT code: {{ clientSelected.vat_code }}</p>
            <p class="m-0">Address: {{ clientSelected.address }}</p>
            <p class="m-0">{{ getCityName(clientSelected.city_id) }}
                <span>{{ clientSelected.post_code }}</span></p>
        </div>
        <div v-else>
            <p class="my-4 text-center">No client selected</p>
        </div>
    </div>
</template>

<script>
export default {
    props: ['clients', 'preselected', 'cities'],
    data() {
        return {
            clientSelected: null,
            clientId: this.preselected
        }
    },
    mounted() {
        this.getClient(this.preselected)
    },
    methods: {
        async getClient(id) {
            this.clientSelected = this.clients.find(client => client.id === id)
            this.$root.clientId = this.clientId
        },
        getCityName(id)
        {
            return this.cities.find(city => city.id === id).name
        },
    }
}
</script>
<style scoped>
select {
    border: none;
    outline: none;
    padding: 10px;
    width: 100%;
}
</style>
