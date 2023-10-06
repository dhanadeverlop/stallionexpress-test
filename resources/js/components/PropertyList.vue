<template>
    <div>
        <input type="text" v-model="keyword" placeholder="Search Keyword">
    </div>
    <div>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">County</th>
                <th scope="col">Country</th>
                <th scope="col">Type</th>
                <th scope="col">Price</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                <tr v-for="proper in property" :key="proper.id">
                    <td>{{ proper.id }}</td>
                    <td><img  :src="proper.image_thumbnail" alt=""></td>
                    <td>{{ proper.county }}</td>
                    <td>{{ proper.country }}</td>
                    <td>{{ capitalized(proper.type) }}</td>
                    <td>{{ proper.price }}</td>
                    <td>
                      <div class="row gap-3">
                        <router-link :to="`/property/${proper.id}`" class="p-2 col border btn btn-primary">View</router-link>
                        <router-link :to="`/property/${proper.id}/edit`" class="p-2 col border btn btn-success">Edit</router-link>
                        <button @click="deleteProperty(proper.id)" type="button" class="p-2 col border btn btn-danger">Delete</button>
                      </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
        keyword: null,
        property: []
    }
  },
  watch: {
        keyword(after, before) {
            this.getPropertyResults();
        }
    },
  async created() {
    try {
      const response = await axios.get('/api/property');
      this.property = response.data;
      console.log("data - ",response.data);
    } catch (error) {
      console.error(error);
    }
  },
  methods: {
    getPropertyResults() {
        axios.get('/api/property-search', { params: { keyword: this.keyword } })
        .then(response => this.property = response.data)
        .catch(error => {});
    },
    async deleteProperty(id) {
      try {
        await axios.delete(`/api/property/${id}`);
        this.property = this.property.filter(proper => proper.id !== id);
      } catch (error) {
        console.error(error);
      }
    },
    capitalized(type) {
      const capitalizedFirst = type[0].toUpperCase();
      const rest = type.slice(1);

      return capitalizedFirst + rest;
    }
  }
}
</script>