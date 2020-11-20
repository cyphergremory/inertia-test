
export const DEBOUNCE_FUNCTION = function debounce(callback, ...params){
    let isActive = false;
    
    if(!isActive){
        return callback(params);
    }
}