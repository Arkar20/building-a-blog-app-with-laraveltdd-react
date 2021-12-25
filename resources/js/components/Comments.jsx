import React, { createContext, useEffect, useReducer } from "react"

import CommentsContainer from "./CommentsContainer"
import ReactDOM from "react-dom";
import RegisterComment from "./RegisterComment";
import { commentsReducer } from "./reducer";

export const CommentContext = createContext();

const Comments = ({thread}) => {

    const [state, dispatch] = useReducer(commentsReducer, { thread, comments: null });

    useEffect(() => {
        const fetchComments = async () => {
            const { data, error } = await axios.get("/comments/" + thread.id);
            
            if (error) return console.log(error)
            
            if(data) dispatch({type:"SET_COMMENTS",payload:data})
        }

        fetchComments();
    }, [])
    
    
    console.log(state);


    return (
        <>
             
                <CommentContext.Provider value={{ state, dispatch }}>
                        <RegisterComment />

                       <CommentsContainer /> 
                </CommentContext.Provider>
            
        </>
    );
    
}

export default Comments;

const commentid = document
    .getElementById("comments");

if (commentid) {
    const thread = JSON.parse(
        document.getElementById("comments").getAttribute("thread")
    );

    ReactDOM.render(
        <Comments thread={thread} />,
        document.getElementById("comments")
    );
}