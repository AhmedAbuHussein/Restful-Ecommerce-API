<template>
  <div class="content">

      <div class="card">
          <div class="card-body">
              <div class="row">
                <div class="col-md-5 col-lg-4">
                    <label class="img btn btn-outline-success" for="file">
                        <img :src="image">
                        press to upload image
                    </label>
                    <!--<label class="btn btn-outline-success" id="filelable" >Add Image</label>-->
                    <input id="file" type="file" size="1" accept="image/*" @change="loadimage">
                    <div class="form-group">
                        <button v-on:click="send" class="btn btn-block btn-outline-primary">Save</button>
                    </div>
                </div>
                <div class="col-md-7 col-lg-8">
                    <div class="info">
                            <div class="form-group">
                                <label for="name">Product Name</label>
                                <input v-model="name" id="name" type="text" class="form-control" placeholder="Product Name">
                            </div>
                            <div class="form-group">
                                <label for="description">Product Description</label>
                                <textarea v-model="desc" id="description" class="form-control" placeholder="Product description">
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label for="price">Product Price</label>
                                <input v-model="price" id="price" type="text" class="form-control" placeholder="Product price">
                            </div>
                            <div class="form-group">
                                <label for="discount">Product discount</label>
                                <input v-model="discount" id="discount" type="text" class="form-control" placeholder="Product discount">
                            </div>
                            <div class="form-group">
                                <label for="stock">Product stock</label>
                                <input v-model="stock" id="stock" type="text" class="form-control" placeholder="Product stock">
                            </div>
                    </div>
                </div>
              </div>
          </div>
      </div>

  </div>
</template>
<script>
import axios from 'axios';
export default {
        props:['_token'],
        data(){
            return{
                image:"",
                imgpath:"",
                name:"",
                desc:"",
                price:"",
                discount:"",
                img:"",
                stock:"",
                errorItems:Array(),
                file : null,
            }
        },
        methods:{
            
            loadimage(e){
                let img = e.target.files[0];
                let form = new FormData();
                form.append("name",this.name);
                form.append("description",this.desc);
                form.append("price",this.price);
                form.append("discount",this.discount);
                form.append("stock",this.stock);
                form.append("img",img);
                this.file = form;

                let reader = new FileReader();
                reader.readAsDataURL(img);
                reader.onload = e=>{
                    this.image = e.target.result;
                }
            },
            send(){
                this.validateData;
                let message = "";
                this.errorItems.forEach(element => {
                    message += element+"\n";
                   
                });
                
                if(message.trim() !== ""){
                    swal({
                        icon:"warning",
                        text:message,
                    })
                }else{
                    axios.post('/saveimage',this.file).then(response=>{
                        this.img = response.data;
                    }).catch(e=>{
                         swal({
                            icon:"warning",
                            text:"faild to upload image",
                         });
                    })
                   
                }
            }
        },
        computed:{
            validateData(){
                this.errorItems = [];
                if(this.name.length < 3){
                    this.errorItems.push("Name must be more tha 3 charcters!");
                }
                if(this.desc.length < 10){
                    this.errorItems.push("Description must be more tha 10 charcters!");
                }
                if(this.price.length <= 0){
                    this.errorItems.push("Invalid value for price!");
                }
                if(this.discount.length <= 0){
                    this.errorItems.push("Invalid value for discount!");
                }
                if(this.stock.length <= 0){
                    this.errorItems.push("Invalid value for stock!");
                }
                if(isNaN(this.price)){
                    this.errorItems.push("Price must be a Number!");
                }
                if(isNaN(this.discount)){
                    this.errorItems.push("Discount must be a Number!");
                }
                if(isNaN(this.stock)){
                    this.errorItems.push("Stock must be a Number!");
                }
            }
        }
}
</script>
<style>
.img{
    width: 100%;
    margin: auto;
    margin-top: 1rem;
    padding: 0.2rem;
    border: 0.05rem solid #000;
    height: 20rem;
    box-sizing: border-box;
    border-radius: 1rem;
    overflow: hidden;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 13pt;
}
.img img{
    box-sizing: border-box;
    max-width: 100%;
    max-height:100%;
}

input[type='file']{
    height: 0;
    visibility: hidden;
}
</style>
