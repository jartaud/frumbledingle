<template>
    <div class="mt-5">
        <button class="btn btn-sm btn-success mb-2" @click="creating = true" v-show="!creating">
            <i class="fa fa-plus"></i>
            Create New Item
        </button>

        <form @submit.prevent="createItem" method="post" v-show="creating">
            <div class="row">
                <div class="col-md-6 my-1">
                    <label class="sr-only" for="name">Name</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <div class="input-group-text">Name</div>
                        </div>
                        <input type="text" class="form-control" id="name" placeholder="Item Name" v-model.trim="form.name" required>
                    </div>
                    <div class="text-danger" v-if="errors && errors.name">
                        <small>{{ errors.name[0] }}</small>
                    </div>
                </div>
                <div class="col-md-6 my-1">
                    <label class="sr-only" for="price">Price</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <div class="input-group-text">Price</div>
                        </div>
                        <input type="number" class="form-control" id="price" placeholder="Item Price" v-model.trim="form.price" step=".01" required>
                    </div>
                    <div class="text-danger" v-if="errors && errors.price">
                        <small>{{ errors.price[0] }}</small>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 my-1">
                    <label class="sr-only" for="location_id">Location</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Location</div>
                        </div>
                        <select class="custom-select" id="location_id" v-model="form.location_id" required>
                            <option :value="null">----</option>
                            <option v-for="location in locations" :value="location.id">{{ location.name }}</option>
                        </select>
                    </div>
                    <div class="text-danger" v-if="errors && errors.location_id">
                        <small>{{ errors.location_id[0] }}</small>
                    </div>
                </div>
                <div class="col-md-6 my-1">
                    <label class="sr-only" for="category_id">Category</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Category</div>
                        </div>

                        <select class="custom-select" id="category_id" v-model="form.category_id" required>
                            <option :value="null">----</option>
                            <optgroup v-for="category in categories" :label="category.name">
                                <option v-if="!category.children_recursive.length" :value="category.id">{{ category.name }}</option>
                                <option v-for="child in category.children_recursive" :value="child.id">{{ child.name }}</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="text-danger" v-if="errors && errors.category_id">
                        <small>{{ errors.category_id[0] }}</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 my-2">
                    <button type="submit" class="btn btn-primary btn-sm" :disabled="saving">Save</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            
            <div class="mt-4 mb-2">
                <label class="sr-only" for="location_filter">Filter by location</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Filter by location</div>
                    </div>
                    <select class="custom-select" id="location_filter" v-model="location_filter"
                        @change="getItems(1)"
                    >
                        <option :value="null">----</option>
                        <option v-for="location in locations" :value="location.id">{{ location.name }}</option>
                    </select>
                </div>
            </div>

            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th></th>
                </thead>
                <tbody>

                    <template v-for="(item, k) in items.data">
                        <tr :key="`details-${k}`">
                            <td>{{ item.id }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.price_dsp }}</td>
                            <td>{{ item.category.name }}</td>
                            <td align="center">
                                <button class="btn btn-danger btn-sm" @click.prevent="deleteItem(item.id, item.name)"
                                    :disabled="deleting && deletingIds.includes(item.id)"
                                >
                                    <i class="fa fa-times" />
                                    <span class="d-none d-lg-inline">Delete</span>
                                </button>
                            </td>
                        </tr>
                    </template>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">
                            <pagination :data="items" @pagination-change-page="getItems"></pagination>
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Pagination from "laravel-vue-pagination";

export default {
    data() {
        return {
            items: {},

            form: {
                name: null,
                price: null,
                category_id: null,
                location_id: null,
            },
            location_filter: null,

            creating: false,
            saving: false,
            errors: {},

            deleting: false,
            deletingIds: [],
        };
    },

    components: {
        Pagination
    },

    props: {
        locations: Array,
        categories: Array,
    },

    mounted() {
        this.getItems();
    },
    methods: {

        async getItems(page = 1) {
            try {
                let url = `/api/items?page=${page}`

                if (this.location_filter) url += `&location=${this.location_filter}`

                const response = await axios.get(url);
                this.items = response.data;
            } catch(data) {
                return console.error(data);
            }
        },

        async createItem() {
            this.errors = {}
            this.saving = true
            try {
                await axios.post('/api/items', this.form);
                await this.getItems();
                this.creating = false
                this.saving = false
                return this.form = {
                    name: null,
                    price: null,
                    category_id: null,
                    location_id: null,
                };
          } catch({response}) {
              if (response.status == 422) this.errors = response.data
              else if (response.data && response.data.error) alert(response.data.error)
              this.saving = false
              return console.error('ItemsTable.createItems -> ', response);
          }
        },

        async deleteItem(id, name) {
            if(!confirm(`Are you sure you want to delete: '${name}'?`)) return

            this.deletingIds.push(id);
            this.deleting = true;

            try {
                await axios.post(`/api/items/${id}`, { _method: 'DELETE' });
                this.getItems();
                this.deleting = false;
                this.deletingIds = [];
            } catch({response}) {
                this.deleting = false;
                if (response.data && response.data.error) alert(response.data.error)
                return console.error('ItemsTable.deleteItem -> ', response);
            }
        },
    }
}
</script>

<style>
.create-location-form {
    margin-bottom: 10px;
}
</style>