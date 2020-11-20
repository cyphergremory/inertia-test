<template>
    <div class="flex flex-row rounded-md bg-gray-100 border-1 border-gray-300 py-1 focus-within:bg-white">
        <input class="flex-1 px-3 bg-transparent border-none focus:border-none focus:outline-none"
          v-model="search"
         >
        <button type="button" class="text-red-300 px-2" @click="clean">
            x
        </button>
    </div>
</template>
<script>
export default {
    props:{
        styles:String,
        val:{
            type:String,
            default:''
        },
        id:{
            type:String,
            required:true
        }
    },
    computed:{
        searchString:function(){
            return this.search;
        }
    },
    data(){
        return {
            search: this.val,
            searching:false
        }
    },
    methods:{
        emitValue:function(){
            setTimeout(this.emitSearchString,500);
            
        },
        clean:function(){
          this.search = '';
        },
        triggerSearch:function(){
            this.$emit('input-emit',{
                'id' : this.id,
                'value' :this.searchString
            });
        }
    },
    watch:{
        search:function(val)
        {
            console.log('asdasd');
            if(!this.searchingVal){
                setTimeOut(()=>{
                    this.triggerSearch(val);
                    this.searching = true;
                },500);
            }
            this.searching = false;
        }
    }
}
</script>