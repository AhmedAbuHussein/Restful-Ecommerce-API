<template>
  
  <div id="review">

      <div class="card col-md-8 mr-auto  ml-auto mb-4  text-center" v-for="(review,index) in reviews" :key="index">
          <div class="card-body">
              <div class="card-title">
                  <h3 v-text="review.customer"></h3>
              </div>
              <p v-text="review.review"></p>
              <p>
                  <i v-for="s in parseInt(review.star.toFixed(0))" :key="s" class="fa fa-star"></i>
                  <i v-for="s in 5-parseInt(review.star.toFixed(0))" class="fa fa-star-o"></i>
              </p>
          </div>
      </div>

  </div>

</template>
<script>
import axios from 'axios';
export default {
    name:"review",
    props:['itemid'],
    data(){
        return{
            reviews:"",
            url:"/api/products/",
        }
    },
    methods:{
        getreview(id=1){
            axios.get(this.url+id+"/reviews").then(response=>{
                this.reviews = response.data.data; 
                
            }).catch(e=>{
               console.log(e.data);
            })
        },
        
    },
    created(){
        this.getreview(this.itemid);
        
    }
  
}
</script>
<style>

</style>

