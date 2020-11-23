
<template>
  <div class="flex flex-wrap align-center justify-center py-2 border-t border-gray-100">
   
    <div>
      <nav class="relative z-0 inline-flex shadow-sm -space-x-px" aria-label="Pagination">        
        <a class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50" 
          v-for="(link,key) in links" :key="key" :class="{'active':link.active == true}"          
          @click.prevent="togglePage(link.label)"
        >
          {{link.label}}
        </a>       
      </nav>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    links: Array,
    current:{
      type:Number,
      default:1
    }
  },
  data(){
    return{
      page: this.current
    }
  },
  watch:{
      page:function(newVal){
        this.$emit('pageChanged',newVal);
      }
  },
  methods:{
      togglePage:function(val){
          this.page = val;
      }
  },
  mounted(){
    console.log(this.links);
  }
}
</script>

<style scoped>
  .active{
    background:dodgerblue;
    color:white;

  }
</style>