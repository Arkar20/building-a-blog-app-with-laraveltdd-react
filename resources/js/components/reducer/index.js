

const commentsReducer = (state=[] , action) => {
    switch (action.type) {

        case "SET_COMMENTS": 
            return action.payload;
        
        default: {
            return state;
        }
    }
    
}


module.exports= {commentsReducer}