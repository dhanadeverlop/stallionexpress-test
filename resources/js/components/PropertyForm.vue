<template>
  <div class="row">
      <div class="col-12">
          <div class="card">
              <div class="card-header">
                <h2 v-if="isNewProperty">Add Property</h2>
                <h2 v-else>Edit Property</h2>
              </div>
              <div class="card-body">
                  <form @submit.prevent="submitForm" enctype="multipart/form-data">
                      <div class="row">
                        <div class="col-12 mb-2">
                              <div class="form-group">
                                  <label>County</label>
                                  <input type="text" class="form-control" v-model="property.county">
                              </div>
                          </div>
                          <div class="col-12 mb-2">
                              <div class="form-group">
                                  <label>Country</label>
                                  <input type="text" class="form-control" v-model="property.country">
                              </div>
                          </div>
                          <div class="col-12 mb-2">
                              <div class="form-group">
                                  <label>Town</label>
                                  <input type="text" class="form-control" v-model="property.town">
                              </div>
                          </div>
                          <div class="col-12 mb-2">
                              <div class="form-group">
                                  <label>Postcode</label>
                                  <input type="text" class="form-control" >
                              </div>
                          </div>
                          <div class="col-12 mb-2">
                              <div class="form-group">
                                  <label>Description</label>
                                  <textarea class="form-control" v-model="property.description"></textarea>
                              </div>
                          </div>
                          <div class="col-12 mb-2">
                              <div class="form-group">
                                  <label>Address</label>
                                  <textarea class="form-control" v-model="property.address"></textarea>
                              </div>
                          </div>
                          <div class="col-12 mb-2">
                              <div class="form-group">
                                  <label>Image</label>
                                  <div v-if="isNewProperty">
                                    
                                  </div>
                                  <div v-else>
                                    <img  :src="property.image_thumbnail" alt="">
                                  </div>
                                  <input type="file" class="form-control" v-on:change="onChange">
                              </div>
                          </div>  
                        <div class="col-12 mb-2">
                              <div class="form-group">
                                  <label>Number of bedrooms</label>
                                  <select class="form-control" v-model="property.num_bedrooms">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                    <option>11</option>
                                    <option>12</option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-12 mb-2">
                              <div class="form-group">
                                  <label>Number of bathrooms</label>
                                  <select class="form-control" v-model="property.num_bathrooms">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                    <option>11</option>
                                    <option>12</option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-12 mb-2">
                              <div class="form-group">
                                  <label>Price</label>
                                  <input type="number" class="form-control" v-model="property.price">
                              </div>
                          </div>
                          <div class="col-12 mb-2">
                              <div class="form-group">
                                  <label>Property Type</label>
                                  <input type="radio" id="propertySale" value="sale" v-model="property.type" />
                                  <label for="propertySale">Sale</label>
                                  <input type="radio" id="propertyRent" value="rent" v-model="property.type" />
                                  <label for="propertyRent">Rent</label>
                              </div>
                          </div>
                          <div class="col-12">
                              <button type="submit" v-if="isNewProperty" class="btn btn-primary">Add Propert</button>
                              <button type="submit" v-else class="btn btn-primary">Update Property</button>
                          </div>
                      </div>                        
                  </form>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data(){
      return {
          property:{
              county:"",
              country:"",
              town:"",
              description:"",
              address:"",
              image_full:"",
              num_bedrooms:"",
              num_bathrooms:"",
              price:"",
              type:""
          }
      }
  },
  computed: {
    isNewProperty() {
      return !this.$route.path.includes('edit');
    }
  },
  async created() {
    if (!this.isNewProperty) {
      const response = await axios.get(`/api/property/${this.$route.params.id}`);
      this.property = response.data;
    }
  },
  methods: {
    onChange(e) {
        this.property.image_full = e.target.files[0];
    },
    async submitForm() {
      try {
        if (this.isNewProperty) {
         
          let formData = new FormData();

          formData.append("county", this.property.county);
          formData.append("country", this.property.country);
          formData.append("town", this.property.town);
          formData.append("description", this.property.description);
          formData.append("address", this.property.address);
          formData.append("image_full", this.property.image_full);
          formData.append("num_bedrooms", this.property.num_bedrooms);
          formData.append("num_bathrooms", this.property.num_bathrooms);
          formData.append("price", this.property.price);
          formData.append("type", this.property.type);

          await axios.post('/api/property', formData);
        } else {
          console.log(this.property);
          await axios.put(`/api/property/${this.$route.params.id}`, this.property);
        }
        //this.$router.push('/');
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>

