import { toast } from "react-toastify";
import { useCommentContext } from "../hooks/useCommentContext.js";

const resetComments = async (url,operation)=>{

    await operation();

    const { data: response } = await axios.get(
       url
    ).catch(err=>console.log(err));

    return  response;
}

const CommentSingle = ({ comment }) => {
    const { state, dispatch } = useCommentContext();

    const handleDelete = async (e) => {
        
    e.preventDefault();

      const response = await resetComments(
   
          "/comments/" + comment.threadid, //url to refetch
          async () => {
              const { data } = await axios
                  .delete(`/comments/${comment.id}/delete`)
                  .catch((error) => toast("Sorry Cannot Delete"));
              if (data) toast("Delete Successful");
          },
      );
        if (response) dispatch({ type: "SET_COMMENTS", payload: response });
    };

   

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
    };

    const hadleSubmitMarkBest =async (e) => {
        e.preventDefault();

         const { data } = await axios
             .post(`/comment/${comment.id}/bestcomment`)
             .catch((error) => toast("Sorry Cannot Favouirted"));
        
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
                    <div className="card-header d-flex gap-4">
                        <h4 className="flex-md-grow-1">{comment.ownername}</h4>
                        {comment.permission_to_delete && (
                            <button
                                type="button"
                                className="btn btn-danger"
                                onClick={handleDelete}
                            >
                                Delete
                            </button>
                        )}
                        {comment.is_best && (
                            <button className="btn btn-success">
                                Best Comment
                            </button>
                        )}
                    </div>
                    <div className="card-body d-flex">
                        <p
                            className="flex-grow-1"
                            dangerouslySetInnerHTML={{ __html: comment.title }}
                        ></p>

                        <div className="btn-section d-flex ">
                            <button
                                className={
                                    comment.is_favourited
                                        ? "btn btn-primary"
                                        : "btn btn-light"
                                }
                                onClick={handleFavourite}
                            >
                                {comment.favourites_count} Favourite
                            </button>

                            {isAdmin && (
                                <button
                                    className="btn btn-danger"
                                    onClick={hadleSubmitMarkBest}
                                >
                                    Mark As Best
                                </button>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default CommentSingle;
