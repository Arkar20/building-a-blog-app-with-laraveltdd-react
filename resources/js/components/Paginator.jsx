import { React, useEffect } from "react"

import { useCommentContext } from "../hooks/useCommentContext.js";

const Paginator = () => {
    
    const { state, dispatch } = useCommentContext();

    const handlePaginate = async (url) => {
        const { data } = await axios.get(url)
        
        if(data) dispatch({type:"SET_COMMENTS",payload:data})
        
        history.pushState(null,'',url)
    }

    return (
        <nav aria-label="Page navigation example">
            
            <ul className="pagination">
                {state.comments && state.comments.meta.links.map((link,index) => {
                    return (
                        <li
                            key={index}
                            className={
                                link.active ? "page-item active" : "page-item"
                            }
                        >
                            <button
                                className="page-link"
                                onClick={() => handlePaginate(link.url)}
                                dangerouslySetInnerHTML={{
                                    __html: link.label,
                                }}
                            >
                                
                            </button>
                        </li>
                    );
               }) }
                
            </ul>
        </nav>
    );
}
 
export default Paginator;