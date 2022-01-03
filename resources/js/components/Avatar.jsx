import { ToastContainer, toast } from "react-toastify";
import { useRef, useState } from "react";

import ReactDOM from "react-dom";

const Avatar = ({ auth }) => {

    const [avatarimg, setAvatarimg] = useState(auth.avatarPath);

    const uploadbtn = useRef();
    
    const handleSubmitAvatar = (e) => {
        const file = new FileReader();
        file.readAsDataURL(e.target.files[0]);

        file.onload = (e) => {

            setAvatarimg(e.target.result);
        };
        
        const formdata = new FormData();
        formdata.append('avatar', e.target.files[0]);
        
        axios
            .post("/profile/" + auth.name + "/avatar", formdata)
            .then((res) => toast(
              "Success"
            )).catch(err=>console.error(err));
    };

    return (
        <form className="container">
            <div className=" d-flex align-items-md-center">
                <img src={avatarimg} width="100" height="100" />
                <h1>{auth.name}</h1>
            </div>

            <input
                ref={uploadbtn}
                type="file"
                name="avatar"
                onChange={handleSubmitAvatar}
                className=" d-none"
            />

            <button
                type="button"
                className="btn btn-success"
                onClick={() => uploadbtn.current.click()}
            >
                Upload Profile
            </button>
        </form>
    );
};
export default Avatar;

const avatarid = document.getElementById("avatar");

if (avatarid) {
    const authuser =JSON.parse(avatarid.getAttribute("authuser"));
    
    ReactDOM.render(<Avatar auth={authuser}/>, document.getElementById("avatar"));
}

