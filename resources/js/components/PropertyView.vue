<template>
  <div>
      <img  :src="property.image_thumbnail" alt="">
      <h5 id="associating-form-text-with-form-controls">County:</h5>
      <h6>{{ property.county }}</h6>
      <h5 id="associating-form-text-with-form-controls">Country:</h5>
      <p>{{ property.country }}</p>
      <h5 id="associating-form-text-with-form-controls">Description:</h5>
      <p>{{ property.description }}</p>
      <h5 id="associating-form-text-with-form-controls">Town:</h5>
      <p>{{ property.town }}</p>
      <h5 id="associating-form-text-with-form-controls">Address:</h5>
      <p>{{ property.address }}</p>
      <h5 id="associating-form-text-with-form-controls">Number of Bedrooms:</h5>
      <p>{{ property.num_bedrooms }}</p>
      <h5 id="associating-form-text-with-form-controls">Number of Bathrooms:</h5>
      <p>{{ property.num_bathrooms }}</p>
      <h5 id="associating-form-text-with-form-controls">Price:</h5>
      <p>{{ property.price }}</p>
      <h5 id="associating-form-text-with-form-controls">Property Type:</h5>
      <p>{{ property.type }}</p>
      <router-link :to="`/property/${property.id}/edit`" class="btn btn-primary">Edit</router-link>
  </div>
</template>

<script>
import axios from 'axios';

export default {
data() {
  return {
    property: {}
  }
},
async created() {
  try {
  const response = await axios.get(`/api/property/${this.$route.params.id}`);
  this.property = response.data;
  console.log(response.data);
  } catch (error) {
  console.error(error);
  }
}
}
</script>