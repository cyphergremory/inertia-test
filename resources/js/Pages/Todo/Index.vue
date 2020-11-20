<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Todo-list {{paginationLinks}}
            </h2>
        </template>        
        <div class="py-12">
            <div class="max-w-7x1 lg:max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full flex flex-row bg-white alignn-center justify-center shadow-sm">
                    <div class="w-4/6">
                        <material-input 
                            @refreshQuery="reloadQueryString"
                            :searchString="query"
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
        <pagination-layout
            v-bind:links="paginationLinks"
        ></pagination-layout>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import SearchBar from '@/Components/Searchbar'
    import Pagination from '@/Components/Pagination'

    export default {
        data(){
            return{
                query:this.queryString,
                pageSize:this.perPage,
                currentPage:this.current,
                paginationLinks:this.links
            }
        },
        components: {
            AppLayout,
            'material-input':SearchBar,
            'pagination-layout':Pagination
        },
        props:{
            items:Array,          
            queryString:String,
            perPage:String,
            current:Number,
            links:Object
        },
        methods:{
            reloadQueryString:function(val){
              this.query = val;
            },
        },   
        watch:{
            'items.per_page':function(newVal){
                console.log(newVal);
            },
            query:function(newVal){   
                this.$inertia.replace(route('items.index'),{
                    data:{
                        query:newVal
                    }   
                });                
            },
            pageSize:function(newVal){
                let obj ={ 
                    data:{
                        perPage:this.pageSize,
                        page:this.currentPage
                    }
                };

                if(this.query !== null && this.query != ''){
                    obj.data.query= this.query;
                }
                
                this.$inertia.replace(route('items.index'),obj);
            }
        },
        mounted(){
            console.log(this.paginationLinks)
        }
    }
</script>
