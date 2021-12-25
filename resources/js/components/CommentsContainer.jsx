import React,{useContext, useState} from "react";

import {CommentContext} from './Comments'
import CommentSingle from "./CommentSingle";
import Paginator from "./Paginator";

const CommentsContainer = () => {

    const { state, dispatch } = useContext(CommentContext);

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