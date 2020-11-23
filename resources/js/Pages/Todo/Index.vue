<template>
    <app-layout>
        <template #header>     
            <div class="flex flex-row">
                <h2 class="font-semibold text-4xl text-gray-600 leading-tight">
                    Todo-list
                </h2>
                <div class="ml-auto">
                    <jet-button type="button" @item-creation="createRow">
                        Registrar item    
                    </jet-button>                
                </div>               
            </div>
        </template>        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-row align-center justify-center">
                    <div class="pl-7 pt-6 text-sm text-gray-600 text-center font-semibold">
                        Mostrando pagina {{page}} de {{count}}
                    </div>
                    <div class="w-3/6 ml-auto">
                        <material-input 
                            @refreshQuery="search"
                            @size-changed="changeSize"
                            :searchString="this.query"
                        ></material-input>
                    </div>                                                                                                                 
                </div>         
                <div class="bg-white rounded-md mt-5 overflow-hidden overflow-x-scroll sm:rounded-md">  
                                                                   
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                            <th class="px-6 py-4 bg-gray-50 text-left text-md leading-4 font-bold text-gray-500 uppercase tracking-wider">
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
                                <div class="text-sm leading-5 font-medium text-gray-900 truncate relative max-w-md">
                                    {{item.description}}
                                </div>                            
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                                </span>
                            </td>
                           
                            <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            </td>
                            </tr>

                            <!-- More rows...-->
                        </tbody>
                    </table>                     
                    <pagination-layout
                        v-bind:links="paginationLinks"
                        @pageChanged="(val) =>{this.page =val;}"
                    ></pagination-layout>                                       
                </div>
            </div>
        </div>                
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import SearchBar from '@/Components/Searchbar'
    import Pagination from '@/Components/Pagination'
    import Button from '@/Components/RegistrationButton'

    export default {
        components:{
            AppLayout,
            'material-input':SearchBar,
            'pagination-layout':Pagination,
            'jet-button':Button
        },
         props:{
            dataset:Object,           
        },
        data(){
            return{
                items:this.dataset.data,
                query:this.dataset.queryString,            
                paginationLinks:this.dataset.links,         
                pageSize:this.dataset.perPage,
                page:1,
                count:7
            }
        },     
        methods:{
            search:function(val){
                this.query = val;
            },
            createRow:function(){
                alert('asdasd');
            },
            changeSize:function(val){                
                this.pageSize = val;               
            }
           
        },
        watch:{           
            query:function(newVal){       
                
               this.$inertia.get('/items',{                
                    query:newVal,
                    size:this.pageSize
               });
            },
            pageSize:function(newVal){   
               this.$inertia.get('/items',{                
                    query:this.query,
                    size:newVal
               });
            }
        }        
    }
</script>
