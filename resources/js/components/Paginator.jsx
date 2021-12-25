import { React, useContext } from "react"

import { CommentContext } from "./Comments"

const Paginator = () => {
    
    const { state, dispatch } = useContext(CommentContext);

    const handlePaginate = async (url) => {
        const { data } = await axios.get(url)
        
        if(data) dispatch({type:"SET_COMMENTS",payload:data})
        
        history.pushState(null,'',url)
    }

    return (
        <nav aria-label="Page navigation example">
            
            <ul class="pagination">
                {state.comments && state.comments.links.map((link) => {
                    return (
                        <li className={link.active&&"page-item active"}>
                            <button className="page-link" onClick={()=>handlePaginate(link.url)}>
                                {link.label}
                            </button>
                        </li>
                    );
               }) }
                
            </ul>
        </nav>
    );
}
 
export default Paginator;