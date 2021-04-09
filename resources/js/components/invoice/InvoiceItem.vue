<template>
    <div class="root">
        <div class="alert-danger rounded p-2" v-if="errors.client">{{ errors.client[0] }}</div>
        <div class="alert-danger rounded p-2" v-else-if="errors.items">{{ errors.items[0] }}</div>
        <div class="alert-danger rounded p-2" v-else v-for="(error, index) in errors" :key="error.id">
            {{ Number(index.charAt(0)) + 1 }} {{ error[0] }}
        </div>
        <div class="items" v-if="items.length > 0">
            <div v-for="(item, index) in items" :key="item.id">
                <div class="items row px-3 mt-2 mx-2">
                    <div class="col-auto text-danger align-self-center">
                        {{ index + 1 }}
                    </div>
                    <div class="col-6">
                        <input :id="index" class="form-control" type="text" name="name" placeholder="Product / Item name"
                               v-model.trim="item.name"
                               @change="sendToBlade" required>
                    </div>
                    <div class="col">
                        <input class="form-control" type="number" name="price" step="0.01" min="0.01" placeholder="0.00"
                               v-model="item.price"
                               @change="sendToBlade" required>
                    </div>
                    <div class="col">
                        <input class="form-control" type="number" name="qty" step="1" min="1" placeholder="0"
                               v-model="item.qty"
                               @change="sendToBlade" required>
                    </div>
                    <div class="col">
                        <select class="form-control" name="unit" v-model="item.unit" @change="sendToBlade" required>
                            <option v-for="unit in units" :key="unit.id" :value="unit.id">{{ unit.name }}</option>
                        </select>
                    </div>
                    <div class="col">
                        <input class="form-control" type="text" name="sum" placeholder="0" disabled v-model="item.price * item.qty">
                    </div>
                    <div class="action align-self-center">
                        <button class="btn-sm btn-danger float-right" @click="deleteField(item.id)">X</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="items row px-3 mt-5">
            <div class="col-6 p-0">
                <input class="form-control" type="text" name="name" placeholder="Product / Item name"
                       v-model.trim="item.name">
            </div>
            <div class="col-2 p-0">
                <input class="form-control" type="number" name="price" step="0.01" min="0.01" placeholder="0.00"
                       v-model="item.price" required>
            </div>
            <div class="col-1 p-0">
                <input class="form-control" type="number" name="qty" step="1" min="1" placeholder="0"
                       v-model="item.qty" required>
            </div>
            <div class="col-1 p-0">
                <select class="form-control" name="unit" v-model="item.unit" required>
                    <option v-for="unit in units" :key="unit.id" :value="unit.id">{{ unit.name }}</option>
                </select>
            </div>
            <div class="col-2 p-0">
                <input class="form-control" type="text" name="sum" placeholder="0" value="0.00" disabled v-model="sum">
            </div>

            <div class="action">
                <button class="btn btn-success mt-2" @click="saveItem">Save item</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['errors', 'units', 'olds'],
    data() {
        return {
            item: {
                id: '',
                name: '',
                price: 0,
                qty: 0,
                unit: 1,
                sum: 0
            },
            items: [],
            errNo: 1
        }
    },
    created() {
        this.checkForOldData()
    },
    computed: {
        sum() {
            return this.item.sum = Math.floor((this.item.price * this.item.qty) * 100) / 100
        },
    },
    methods: {
        fixSum(price, qty) {
            return Math.floor((price * qty) * 100) / 100
        },
        checkForOldData() {
            if (this.olds.length > 0)
                this.items = JSON.parse(this.olds)

            this.sendToBlade()
        },
        saveItem() {
            this.items.push({
                id: Date.now(),
                name: this.item.name,
                price: this.item.price,
                qty: this.item.qty,
                unit: this.item.unit,
                sum: this.item.sum
            })
            this.sendToBlade()
            this.createNewField()
        },
        createNewField() {
            this.item.id = ''
            this.item.name = ''
            this.item.price = 0
            this.item.qty = 0
            this.item.unit = 1
            this.item.sum = 0
        },
        deleteField(id) {
            this.items = this.items.filter(item => item.id !== id)
            this.sendToBlade()

        },
        getUnitName(id) {
            return this.units.find(unit => unit.id === id).name
        },
        sendToBlade() {
            this.$root.invoiceItems = JSON.stringify(this.items)
        }
    }
}
</script>

<style scoped>
input {
    width: 100%;
}
</style>
