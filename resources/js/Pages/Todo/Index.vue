<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Todo-list
            </h2>
        </template>        
        <div class="py-12">
            <div class="max-w-7x1 lg:max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full flex flex-row bg-white alignn-center justify-center shadow-sm">
                    <div class="w-4/6">
                        <material-input 
                            @refreshQuery="refreshQuery"
                            :searchString="this.query"
                        ></material-input>
                    </div>
                    <div class="flex-1">                         
                        <div class="relative p-2">
                            <select id="country" 
                                class="mt-1 border-l border-gray-200 block w-full py-2 px-3 bg-white focus:outline-none focus:border-gray-500 sm:text-sm"
                                v-model="pageSize"
                            >
                                <option>5</option>
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                        </div>                        
                    </div>
                    </div>       
                 
                <div class="bg-white  mt-5 overflow-hidden shadow-sm sm:rounded-md">                                              
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                #
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Description
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>                       
                            <th class="px-6 py-3 bg-gray-50"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(item,index) in items" :key="index">
                                <td class="px-6 py-4 whitespace-no-wrap">                    
                                <div class="text-sm leading-5 font-medium text-gray-900">
                                    {{item.id   }}
                                </div>                            
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">                    
                                <div class="text-sm leading-5 font-medium text-gray-900">
                                    {{item.name}}
                                </div>                            
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">                    
                                <div class="text-sm leading-5 font-medium text-gray-900">
                                    {{item.description}}
                                </div>                            
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                Admin
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            </td>
                            </tr>

                            <!-- More rows...-->
                        </tbody>
                    </table>                    
                </div>
            </div>
        </div>
        <!--
        <pagination-layout
            v-bind:links="paginationLinks"
        ></pagination-layout>
        -->
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import SearchBar from '@/Components/Searchbar'
    import Pagination from '@/Components/Pagination'

    export default {
         props:{
            collection:Object,           
        },
        data(){
            return{
                items:this.collection.data,
                query:this.collection.queryString,            
                paginationLinks:this.collection.links,
                pageSize:this.collection.links.perPage,
                current:1,
                params:{
                    query:{
                        required:true,
                        remove:false
                    },
                    size:{
                        required:false,
                        remove:false
                    },
                    page:{
                        required:false,
                        remove:false
                    }
                }
            }
        },
        components: {
            AppLayout,
            'material-input':SearchBar,
            'pagination-layout':Pagination
        },       
        methods:{
            refreshQuery:function(val){
                this.query = val;
            },
            requireParam:function(param){
               this.params[param].required = true;
               this.params[param].remove = false;        
            },
            removeParam:function(param){
               this.params[param].required = false;
               this.params[param].remove = true; 
            },
            requestParams:function(params){
                let options ={                   
                        size:this.pageSize,
                        query:this.query,
                        page:this.current                               
                };

                Object.entries(this.params).forEach(entry => {
                    const [key, value] = entry;
                    if (value.required == true && (key in options && options[key] === null || options[key] =='')){
                            delete options[key];
                    }
                    if(value.remove == true){
                        delete options[key];
                    }                  
                });  
                
                return options;
            }
        },   
        computed:{
            hasQuery:function(){
                return this.query !== null && this.query.lenght > 0;
            }
        },
        watch:{           
            query:function(newVal){          
                this.removeParam('size');
                this.removeParam('page');
                this.$inertia.get('/items',this.requestParams());
            },
            pageSize:function(newVal){   
                this.requireParam('size');
                this.requireParam('page');
                this.$inertia.get('/items',this.requestParams());
            }
        },       
        mounted(){
          
        }
    }
</script>
