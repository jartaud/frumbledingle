<template>
    <div class="mt-5">
        <form @submit.prevent="createCategory" method="post">
            <div class="row my-3">
                <div class="col-md-6 my-1">
                    <label class="sr-only" for="name">Name</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <div class="input-group-text">Name</div>
                        </div>
                        <input type="text" class="form-control" id="name" placeholder="Category Name" v-model.trim="form.name" requiredss>
                    </div>
                    <div class="text-danger" v-if="errors && errors.name">
                        <small>{{ errors.name[0] }}</small>
                    </div>
                </div>
                <div class="col-md-4 my-1">
                    <label class="sr-only" for="parent_id">Parent</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Parent</div>
                        </div>
                        <select class="custom-select" id="parent_id" v-model="form.parent_id" requiredss>
                            <option :value="null">----</option>
                            <option v-for="parent in categoryList" :value="parent.id">{{ parent.name }}</option>
                        </select>
                    </div>
                    <div class="text-danger" v-if="errors && errors.parent_id">
                        <small>{{ errors.parent_id[0] }}</small>
                    </div>
                </div>
                <div class="col-md-2 my-1">
                    <button type="submit" class="btn btn-primary btn-sm" :disabled="saving">Save</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <th>ID</th>
                    <th>Parent</th>
                    <th>Name</th>
                    <th></th>
                </thead>
                <tbody>
                    <template v-for="(category, index) in categories.data">
                        <tr :key="`details-${index}`">
                            <td>{{ category.id }}</td>
                            <td>
                                {{ category.parent ? category.parent.name : ''  }}
                            </td>
                            <td>{{ category.name }}</td>
                            <td align="center">
                                <button class="btn btn-danger btn-sm" @click.prevent="deleteCategory(category.id, category.name)"
                                    :disabled="deleting && deletingIds.includes(category.id)"
                                >
                                    <i class="fa fa-times" />
                                    <span class="d-none d-lg-inline">Delete</span>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <pagination :data="categories" @pagination-change-page="getCategories"></pagination>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Pagination from "laravel-vue-pagination";

export default {
    data() {
        return {
            categories: {},
            createdCategory: {},

            form: {
                name: null,
                parent_id: null,
            },

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
        parentCategories: Array,
    },

    mounted() {
        this.getCategories();
    },

    computed: {
        categoryList() {
            let categories = this.parentCategories

            if (this.createdCategory.id && !this.createdCategory.parent_id) {
                categories.push({
                    id: this.createdCategory.id,
                    name: this.createdCategory.name,
                })
            }

            return categories
        }
    },

    methods: {

        async getCategories(page = 1) {
            try {
                const response = await axios.get(`/api/categories?page=${page}`);
                this.categories = response.data;
            } catch(data) {
                return console.error(data);
            }
        },

        async createCategory() {
            this.errors = {}
            this.saving = true
            try {
                const {data} = await axios.post('/api/categories', this.form);
                this.createdCategory = data
                await this.getCategories();
                this.creating = false
                this.saving = false
                return this.form = {
                    name: null,
                    parent_id: null,
                };
          } catch({response}) {
              if (response.status == 422) this.errors = response.data
              else if (response.data && response.data.error) alert(response.data.error)
              this.saving = false
              return console.error('CategoriesTable.createCategory -> ', response);
          }
        },

        async deleteCategory(id, name) {
            if(!confirm(`Are you sure you want to delete: '${name}'?`)) return

            this.deletingIds.push(id);
            this.deleting = true;

            try {
                await axios.post(`/api/categories/${id}`, { _method: 'DELETE' });
                this.getCategories();
                this.deleting = false;
                this.deletingIds = [];
            } catch({response}) {
                this.deleting = false;
                if (response.data && response.data.error) alert(response.data.error)
                return console.error('CategoriesTable.deleteCategory -> ', response);
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