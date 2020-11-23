<template>
    <div class="bg-white p-2 flex flex-row rounded-l-md relative rounded-md shadow-sm">
        <div class="relative flex flex-row flex-1">
        <span class="w-auto flex justify-end items-center text-gray-500 p-2">
           <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </span>
        <input class="w-full rounded py-2 pr-8 focus:outline-none"
            v-model="query" 
            type="text" 
            placeholder="Ej. 'Zapato Cassady'"
            autofocus="true"
         >  
        <transition name="fade">
         <button 
            class="absolute right-3 top-3 text-red-300 hover:text-red-700 z-10 focus:outline-none active:outline-none"
            v-if="hasQueryString"
            v-on:click="clean"
         >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
         </button>
        </transition>
        </div>
        <select id="country" 
            class="mt-1 border-l border-gray-200 block py-2 px-3 bg-white focus:outline-none focus:border-gray-500 sm:text-sm"
            v-model="pageSize"
        >                                   
            <option>10</option>
            <option>25</option>
            <option>50</option>                                
        </select>
    </div>
</template>
<script>
import {debounce} from 'debounce'
export default {
    props:{
        searchString:String,
        perPage:{
            default:10
        }
    },
    data(){
        return {
           query:this.searchString,
           pageSize:this.perPage
        }
    },
    methods:{
        clean:function(){
          this.query = '';
        },
    },
    computed:{
        hasQueryString:function(){
            return null != this.query && this.query.lenght != 0;
        }
    },
    watch:{
        query:debounce(function(){  
            this.$emit('refreshQuery',this.query);
        },500),
        pageSize:function(){
            this.$emit('size-changed',this.pageSize);
        }
    }
}
</script>
<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0
}
</style>