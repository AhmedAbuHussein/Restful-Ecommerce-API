<template>
<div id="cards">
    <div class="col-md-6 ml-auto mr-auto mb-4">
        <input type="search" v-model="search" class="form-control" placeholder="search by name">
    </div>
    <div class="row">
        
        <div class="col-lg-4 col-sm-6 text-center" v-for="(res,index) in searchfun" :key="index">
            <a :href="'item/'+res.id" class="link-card">
            <div class="card mb-2">
                <span class="discount" v-text="res.discount+' %'"></span>  
                <div class="card-body">
                 <div class="card-img"><img :src="res.image" :alt="res.name" class="card-img"/></div>
                    <div class="card-title text-center m-3">
                        <h2 class="text-capitalize" v-text="res.name"></h2>
                    </div>
                    <div class="rate" v-if="!isNaN(res.rate)">
                        <span v-for="item in parseInt(res.rate.toFixed(0))"><i class="fa fa-star"></i></span>
                        <span v-for="item2 in 5-parseInt(res.rate.toFixed(0))"><i class="fa fa-star-o"></i></span>
                    </div>
                    <div class="rate" v-if="isNaN(res.rate)" v-text="res.rate">
                        
                    </div>
                </div>
            </div>
            </a>
        </div>
        
    </div>
     <paginate
            :page-count="pageCount"
            :page-class="'page-link'"
            :click-handler="ajaxfun"
            :prev-text="'<<'"
            :prev-class="'page-link'"
            :next-text="'>>'"
            :next-class="'page-link'"
            :container-class="'pagination justify-content-center'"

        ></paginate>

</div>
</template>

<script>
import axios from 'axios';
    export default {
        name:"cards",
         data(){
             return{
                products:[],
                search:"",
                pageCount:1,
                endpoint:"api/products?page=",
             }
        },
        computed:{
            searchfun:function(){
                var app = this;
                return this.products.filter(function(product){
                    return product.name.indexOf(app.search) !== -1;
                })
            }
        },
    methods:{
        ajaxfun:function(page=1){
            axios.get(this.endpoint + page).then(response => {
                
                this.products = response.data.data;
                this.products = this.products.reverse();

                this.pageCount = response.data.meta.last_page;
  
            }).catch(e => {
                this.errors.push(e)
            });
        }

    },
    created:function(){
         this.ajaxfun();
    }
}

</script>
<style>
.card{
    background: #f3f3f3;
}
.card .card-body img{
    height: 15rem;
}
.link-card{
    text-decoration: none;
    color: initial;
}
.link-card:hover{
    text-decoration: none;
}
.discount{
    position: relative;
    top: 2rem;
    left: 1.2rem;
    background: #6912cc;
    padding: 0.3rem;
    color: white;
    font-size: 14pt;
    border-radius: 0.2rem;
    box-shadow: 0.2rem 0.2rem 0.1rem #c39696;
    width: 4.2rem;
}
.discount::before{
     content: "";
    position: absolute;
    width: 0;
    height: 0;
    border-width: 1.2rem;
    border-style: solid;
    border-color: transparent  #6912cc transparent transparent;
    top: 0;
    left: -2.3rem;
}
.discount::after{
    content: "";
    position: absolute;
    width: 0;
    height: 0;
    border-width: 0.4rem;
    border-style: solid;
    border-color: #fd0e5a  transparent transparent transparent;
    top: 1.1rem;
    right: 0.4rem;
}
.rate{
    font-size: 12pt;
    font-family: Arial, Helvetica, sans-serif;
}
</style>