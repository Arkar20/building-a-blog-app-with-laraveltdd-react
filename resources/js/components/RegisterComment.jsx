import "react-toastify/dist/ReactToastify.css";

import React,{useContext, useEffect, useState} from "react";
import { ToastContainer, toast } from "react-toastify";

import {CommentContext} from './Comments'
import { ReactDOM } from 'react-dom';
import axios from "axios";
import { fetchAllComment } from "./helpers/comments";

const RegisterComment = () => {
    const { state, dispatch } = useContext(CommentContext);
    
    const [title, setTitle] = useState("");
    

    const handleSubmit = async (e) => {
        
        e.preventDefault();
        
      try{  const response = await axios.post("/comments/"+state.thread.id, { title })

        if (response.data) {
            
             toast("Register Successful!");
            
            const { data } = await axios.get(state.thread.path);

            if (data) dispatch({ type: "SET_COMMENTS", payload: data });
            
            setTitle('')
            
            };
      } catch (err) {
          const errormsg = JSON.parse(JSON.stringify(err.response.data));
         
          if(err.response.status==429) return toast(errormsg)

             toast(errormsg.errors.title[0]);

        }
        
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