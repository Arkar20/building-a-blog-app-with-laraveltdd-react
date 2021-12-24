import React, { useContext } from "react";

import { CommentContext } from "./Comments";
import { toast } from "react-toastify";

const CommentSingle = ({ comment }) => {
    const { state, dispatch } = useContext(CommentContext);

    const handleDelete = async (e) => {
        e.preventDefault();
        
        const { data }=await axios.delete(`/comments/${comment.id}/delete`).catch(error=>toast("Sorry Cannot Delete"));

            // if (error)  console.log(error.response.status);

            if(data) toast("Delete Successful")


              const { data:response, err } = await axios.get(
                  "/comments/" + comment.thread.id
              );
        
                console.log(response)

              if (err) return console.log(err);

              if (response) dispatch({ type: "SET_COMMENTS", payload: response });

        
        
    }
    return (
        <>
            <div className="card">
                <div className="card-body">
                    <div className="card-header d-flex ">
                        <h4 className="flex-md-grow-1">{comment.user.name}</h4>
                        <button
                            type="button"
                            className="btn btn-danger"
                            onClick={handleDelete}
                        >
                            Delete
                        </button>
                    </div>
                    <div className="card-body">{comment.title}</div>
                </div>
            </div>
        </>
    );
}
 
export default CommentSingle ;