

const commentsReducer = (state , action) => {
    switch (action.type) {

        case "SET_COMMENTS": 
            return {thread:state.thread,comments:action.payload};
        
        default: {
            return state;
        }
    }
    
}


module.exports= {commentsReducer}