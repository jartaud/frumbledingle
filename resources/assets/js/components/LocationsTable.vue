<template>
    <div class="mt-5">
        <form @submit.prevent="createLocation" method="post">
            <div class="create-location-form input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Name</span>
                </div>
                <input v-model.trim="newLocationName" type="text" class="form-control" placeholder="Location Name" required />
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" :disabled="creating">Create</button>
                </div>
            </div>
            <div class="text-danger" v-if="errors && errors.name">
                <small>{{ errors.name[0] }}</small>
            </div>
        </form>
        <div class="table-responsive mt-2">
            <table class="table  table-striped table-bordered">
                <thead class="thead-dark">
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col"></th>
                </thead>
                <tbody>
                    <tr v-for="row in locations.data" :key="row.id">
                        <td>{{ row.id }}</td>
                        <td>{{ row.name }}</td>
                        <td align="center">
                            <button class="btn btn-danger btn-sm" @click.prevent="deleteLocation(row.id, row.name)"
                                :disabled="deleting && deletingIds.includes(row.id)"
                            >
                                <i class="fa fa-times" />
                                <span class="d-none d-lg-inline">Delete</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">
                            <pagination :data="locations" @pagination-change-page="getLocations"></pagination>
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
            locations: {},
            newLocationName: '',
            creating: false,
            deleting: false,
            deletingIds: [],
            errors: {},
        };
    },

    components: {
        Pagination
    },

    mounted() {
        this.getLocations();
    },

    methods: {
        async getLocations(page = 1) {
            try {
                const response = await axios.get(`/api/locations?page=${page}`);
                this.locations = response.data;
            } catch(data) {
                return console.error(data);
            }
        },

        async createLocation() {
            this.errors = {}
            this.creating = true
            try {
                await axios.post('/api/locations', { name: this.newLocationName });
                await this.getLocations();
                this.creating = false
                return this.newLocationName='';
          } catch({response}) {
              if (response.status == 422) this.errors = response.data.errors
              else if (response.data && response.data.error) alert(response.data.error)
              this.creating = false
              return console.error('LocationsTable.createLocation -> ', response);
          }
        },

        async deleteLocation(id, name) {
            if(!confirm(`Are you sure you want to delete: '${name}'?`)) return

            this.deletingIds.push(id);
            this.deleting = true;

            try {
                await axios.post(`/api/locations/${id}`, { _method: 'DELETE' });
                this.getLocations();
                this.deleting=false;
                this.deletingIds=[];
          } catch({response}) {
                this.deleting = false;
                if (response.data && response.data.error) alert(response.data.error)
                return console.error('LocationsTable.deleteLocation -> ', response);

          }
        }
    }
}
</script>

<style>
.create-location-form {
    margin-bottom: 10px;
}
</style>