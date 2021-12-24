import "react-toastify/dist/ReactToastify.css";

import React,{useContext, useState} from "react";
import { ToastContainer, toast } from "react-toastify";

import {CommentContext} from './Comments'
import { ReactDOM } from 'react-dom';
import axios from "axios";

const RegisterComment = () => {
    const { state, dispatch } = useContext(CommentContext);
    
    const [title, setTitle] = useState("");
    

    const handleSubmit = async (e) => {
        
        e.preventDefault();
        
        const { data, error } = await axios.post("/comments/"+state.thread.id, { title });
        
        if (error) return console.log(error)
        
        if (data) {
            toast("Register Successful!");
            
             const { data, error } = await axios.get("/comments/"+state.thread.id);

             if (error) return console.log(error);

            if (data) dispatch({ type: "SET_COMMENTS", payload: data });
            
            setTitle('')
            
        };
    }
    return (
        <>
            <ToastContainer />
            <h3>Comment Section</h3>
            <form onSubmit={handleSubmit}>
                <input
                    type="text"
                    className="form-control"
                    name="title"
                    value={title}
                    onChange={(e) => setTitle(e.target.value)}
                />
                <button className="btn btn-primary my-2">Comment</button>
            </form>
        </>
    );
}
 


export default RegisterComment;