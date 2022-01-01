import React, { useContext } from "react";

import { CommentContext } from "../components/Comments";

export const useCommentContext = () => {
    
    const { state, dispatch } = useContext(CommentContext);

    return {
        state,
        dispatch
    }
};

