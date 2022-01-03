import ReactDOM from "react-dom";
import { ToastContainer } from "react-toastify";
import UploadBtn from "./UploadBtn";
import { useState } from "react";

const Avatar = ({ auth }) => {

    const [avatarimg, setAvatarimg] = useState(auth.avatarPath);

    
 

    return (
        <form className="container">
            <ToastContainer />
            <div className=" d-flex align-items-md-center">
                <img src={avatarimg} width="100" height="100" />
                <h1>{auth.name}</h1>
            </div>
            <UploadBtn
                setAvatarimg={setAvatarimg}
                url={`/profile/${auth.name}/avatar`}
            />
        </form>
    );
};
export default Avatar;

const avatarid = document.getElementById("avatar");

if (avatarid) {
    const authuser =JSON.parse(avatarid.getAttribute("authuser"));
    
    ReactDOM.render(<Avatar auth={authuser}/>, document.getElementById("avatar"));
}

