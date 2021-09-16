<template>
    <div class="mt-5">

        <div class="table-responsive">
            
            <form @submit.prevent="getReportData" method="post" class="mb-2">
                <div class="create-location-form input-group">
                    <input v-model.trim="price" type="number" step=".01" class="form-control" placeholder="Filter by price" />
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="submit" :disabled="searching">
                            <i class="fa fa-filter"></i>
                        </button>
                        <button class="btn btn-outline-primary" type="button" @click="print">
                            <i class="fa fa-print"></i>
                        </button>
                    </div>
                </div>
            </form>

            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <th>Location</th>
                    <th>Parent Category</th>
                    <th>Category</th>
                    <th>Count</th>
                </thead>
                <tbody>

                    <template v-for="(item, k) in reportData">
                        <tr :key="`details-${k}`">
                            <td>{{ item.location }}</td>
                            <td>{{ item.parent_category }}</td>
                            <td>{{ item.category }}</td>
                            <td>{{ item.total }}</td>
                        </tr>
                    </template>
                    
                </tbody>
            </table>

        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            reportData: [],
            price: 0,
            searching: false,
            printing: false,
        };
    },

    mounted() {
        this.getReportData();
    },

    methods: {

        async getReportData() {
            this.searching = true
            try {
                const price = this.price || 0
                const response = await axios.get(`/api/report?price=${price}`);
                this.reportData = response.data;
                this.searching = false
            } catch({response}) {
                if (response.data && response.data.error) alert(response.data.error)
                this.searching = false
                return console.error('ReportTable.getReportData -> ', response);
            }
        },

        print(){
            window.print()
        }
    }
}
</script>

<style>
.create-location-form {
    margin-bottom: 10px;
}
</style>