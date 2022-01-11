import { useEffect, useState } from "react";

import ReactDOM from "react-dom";

const SearchThread = () => {

  const [search, setSearch] = useState("");
  const [list, setList] = useState(false);
  const [filteredSearchList, setfilteredSearchList] = useState([]);

  useEffect(() => {
    // if list is an empty array fetch from backend api 
    !list && axios.get("/api/searchThreads").then((res) => { setList(res.data.data); setfilteredSearchList(res.data.data) });
    //else filtered the list 
   list && setfilteredSearchList(() => {
      return list.filter(data => data.title.toLowerCase().includes(search));
    })
    
  }, [search]);


  const filteredList =
     filteredSearchList ?
      filteredSearchList.map((list) => (
        <li key={list.path} className="list-group-item">
          <a href={`${list.path}`} class="text-decoration-none">{list.title}</a>
          </li>
      )): <p>No Records Found</p>
    return (
        <div>
            <h3>Search Threads</h3>
            <input
                className="form-control w-full"
                value={search}
                onChange={(e) => setSearch(e.target.value)}
            />
            <div className="list " style={{zIndex: 1001}}>
                <ul className="list-group overflow-scroll" style={{height: "200px"}}>
                    {filteredList}
                </ul>
            </div>
        </div>
    );
};
export default SearchThread;

const serachid = document.getElementById("search");

if (serachid) {
    ReactDOM.render(<SearchThread />, document.getElementById("search"));
}
