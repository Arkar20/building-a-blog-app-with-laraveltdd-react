import React from "react"
import ReactDOM from "react-dom";
import RegisterComment  from "./RegisterComment";
const Comments = ({ comments }) => {
   

    return (
        <>
            
            <RegisterComment />
            
            {comments &&
                comments.data.map((comment) => (
                    <div className="card" key={comment.id}>
                        <div className="card-body">
                            <div className="card-header">{comment.user.name}</div>
                            <div className="card-body">{comment.title}</div>
                        </div>
                    </div>
                ))}
        </>
    );
    
}

export default Comments;

const commentid = document
    .getElementById("comments");

if (commentid) {
    const comments = JSON.parse(commentid.getAttribute("comments"));

    ReactDOM.render(
        <Comments comments={comments} />,
        document.getElementById("comments")
    );
}