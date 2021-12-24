import React,{useContext, useState} from "react";

import {CommentContext} from './Comments'
import CommentSingle from "./CommentSingle";

const CommentsContainer = () => {

    const { state, dispatch } = useContext(CommentContext);



    return (
        <>
            {state.comments
                ? state.comments.map((comment) => (
                      <section key={comment.id}>
                          <CommentSingle comment={comment} />
                      </section>
                  ))
                : "Loading..."}
        </>
    );
}
 
export default CommentsContainer;