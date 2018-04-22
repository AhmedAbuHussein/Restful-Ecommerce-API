<template>

<div id="item">
    <div v-if="find">
    <div class="card mb-4">
        <div class="card-body" >
            <div class="row">
                <div class="col-md-4">
                    <img :src="productitem.image"  class="img-responsive" :alt="productitem.name">
                </div>
                <div class="col-md-8 parent">
                    <h2 v-text="productitem.name"></h2>
                    <p v-text="productitem.description"></p>
                    <p>Owner <span><a :href="'/profile/'+owner.id" v-text="owner.name"></a></span></p>
                    <p>Price<span v-text="productitem.price"></span></p>
                    <p>Discount<span v-text="productitem.discount + '%'"></span></p>
                    <p>Total<span v-text="productitem.totalPrice"></span></p>
                    <div class="rate">
                        <span v-for="item in rate"><i class="fa fa-star"></i></span>
                        <span v-for="item2 in 5-rate"><i class="fa fa-star-o"></i></span>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <message :itemid="productid" :username="username" class="mb-4"></message>
</div>
<div class="card" v-if="!find">

 <div class="card-body text-center">
            <h2 class="text-center">Ther is no data to display!!</h2>
        </div>

</div>

</div>

</template>

<script>
Vue.component('message', require('./addreview.vue'));
import axios from 'axios';
    export default {
        name:"item",
        props:['productid','username'],
        data(){
            return{
                ownerid:1,                
                productitem:'',
                rate:0,
                find:false,
                owner:'',
                product:'/api/products/',
            }
        },
        methods:{

            getitem(id=1){
                axios.get(this.product+id).then(response=>{
                    console.log(response.data.data);
                    if(response.data.data === ""){
                        this.find =false;
                        return;
                    }
                    this.productitem = response.data.data;
                    if(!isNaN(response.data.data.rate)){
                        this.rate = parseInt(response.data.data.rate.toFixed(0));
                    }
                    this.ownerid = parseInt(response.data.data.OwnerID);
                    this.find = true;
                }).catch(e=>{
                    console.log(e)
                })
            },
            getUser(userid){
                axios.get('/users')
                .then(response=>{
                    response.data.forEach(element => {
                        if(element.id == this.ownerid){
                            this.owner = element;
                        }
                    });
                }).catch(e=>{
                    console.log(e.data);
                });
            }

        },
        created(){
            this.getitem(this.productid);
            this.getUser(this.ownerid);
        }
    
    
    }

</script>

<style>

img{
    max-width: 100%;
}
.parent p span{
    display: inline-block;
    width: 80%;
    color: #028bf3;
    float: right;
    font-family: Arial, Helvetica, sans-serif;
}
</style>