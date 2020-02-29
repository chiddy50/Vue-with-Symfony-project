export default {   
    attandanceChecker(state){
        if(!state.classes.length || !state.sections.length){
            return false;
        }else{
            return true;
        }
    }
};