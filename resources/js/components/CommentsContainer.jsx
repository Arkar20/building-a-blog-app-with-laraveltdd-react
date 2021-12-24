import React,{useContext, useState} from "react";

import {CommentContext} from './Comments'

const CommentsContainer = () => {

    const { state, dispatch } = useContext(CommentContext);



    return (
        <>
            
          
            {state.length ?
                state.map((comment) => (
                <div className="card" key={comment.id}>
                    <div className="card-body">
                        <div className="card-header">{comment.user.name}</div>
                        <div className="card-body">{comment.title}</div>
                    </div>
                </div>
            )):"Loading..."}
        </>
    );
}
 
export default CommentsContainer;