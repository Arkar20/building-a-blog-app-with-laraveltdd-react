import React, { useContext } from "react";

import { CommentContext } from "./Comments";
import { toast } from "react-toastify";

const CommentSingle = ({ comment }) => {
    const { state, dispatch } = useContext(CommentContext);

    const handleDelete = async (e) => {
        e.preventDefault();
        
        const { data }=await axios.delete(`/comments/${comment.id}/delete`).catch(error=>toast("Sorry Cannot Delete"));


            if(data) toast("Delete Successful")


              const { data:response, err } = await axios.get(
                  "/comments/" + comment.threadid
              );
        
                console.log(response)

              if (err) return console.log(err);

              if (response) dispatch({ type: "SET_COMMENTS", payload: response });
        
    }

    const handleFavourite = async (e) => {

        
        const { data } = await axios
            .post(`/comments/${comment.id}/favourites`)
            .catch((error) => toast("Sorry Cannot Favouirted"));

        
        if (data) toast(data.message);

         const { data: response, err } = await axios.get(
             "/comments/" + comment.threadid
         );


         if (err) return console.log(err);

         if (response) dispatch({ type: "SET_COMMENTS", payload: response });


        
    }

   
    return (
        <>
            <div className="card">
                <div className="card-body">
                    <div className="card-header d-flex ">
                        <h4 className="flex-md-grow-1">{comment.ownername}</h4>
                     {comment.permission_to_delete &&   <button
                            type="button"
                            className="btn btn-danger"
                            onClick={handleDelete}
                        >
                            Delete
                        </button>}
                    </div>
                    <div className="card-body d-flex">
                        <p className="flex-grow-1" dangerouslySetInnerHTML={{ __html: comment.title }}>
                            {/* {! comment.title !} */}
                        </p>
                        <button className={comment.is_favourited?'btn btn-primary':'btn btn-light'} onClick={handleFavourite}>
                            {comment.favourites_count}  Favourite
                        </button>
                    </div>
                </div>
            </div>
        </>
    );
}
 
export default CommentSingle ;