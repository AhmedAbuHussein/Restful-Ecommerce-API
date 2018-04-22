<template>

    <div id="sendreview">
        <div class="card col-md-8 ml-auto mr-auto mb-4">
            <div class="card-body">
                <label for="message" class="control-label">Message</label>
                <textarea v-model="msg"  id="message" autofocus name="message" class="form-control" placeholder="message"></textarea>
                <label for="rate"class="control-label">Rate</label>
                <select class="form-control mb-3" name="rate" id="rate" v-model="rate">
                    <option value="5">top</option>
                    <option value="4">very good</option>
                    <option value="3">good</option>
                    <option value="2">old</option>
                    <option value="1">bad</option>
                    <option value="0">very bad</option>
                </select>
                <button @click="send" type="button" class="btn btn-outline-primary">Send</button>
            </div>
        </div>
        <review :itemid="itemid"></review>
    </div>

</template>
<script>
import axios from 'axios';

Vue.component('review', require('./itemReview.vue'));

export default {
    name:"sendreview",
  props:['itemid','username'],
  data(){
      return{
          msg:"",
          rate:5,
          url:"/api/products/"+this.itemid+"/reviews",
      }
  },
  methods:{
      send(){
          axios.post(this.url,{"customer":this.username,"review":this.msg,"star":this.rate})
          .then(response=>{
              swal({
                  'text':"Review send successful!!",
                  'icon':'success'
              });
              this.msg="";
              this.rate=5;              
          }).catch(e=>{
               swal({
                    'icon':"warning",
                    'text':"You must login firest !!",
                });
          })
      }
  }
}
</script>
<style>

</style>
