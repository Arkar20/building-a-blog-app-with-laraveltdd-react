import React,{ useState } from "react";

import CommentSingle from "./CommentSingle";
import Paginator from "./Paginator";
import {useCommentContext} from "../hooks/useCommentContext.js"

const CommentsContainer = () => {

    const { state, dispatch } = useCommentContext();

    return (
        <>
            {state.comments
                ? state.comments.data.map((comment) => (
                      <section key={comment.id}>
                          <CommentSingle comment={comment} />

                      </section>
                  ))
                : "Loading..."}
            
            {state.comments && <Paginator links={state.comments.links}/>}
        </>
    );
}
 
export default CommentsContainer;