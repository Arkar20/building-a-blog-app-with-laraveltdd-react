import { showAndUploadFile } from "./HOF";
import { useRef } from "react";

const UploadBtn = ({ setAvatarimg, authname }) => {
    const uploadbtn = useRef();

    return (
        <>
            <input
                ref={uploadbtn}
                type="file"
                name="avatar"
                onChange={(e) => showAndUploadFile(e, setAvatarimg, authname)} //! a higher order fun
                className=" d-none"
            />

            <button
                type="button"
                className="btn btn-success"
                onClick={() => uploadbtn.current.click()}
            >
                Upload Profile
            </button>
        </>
    );
};
export default UploadBtn;
