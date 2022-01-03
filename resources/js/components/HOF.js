import { toast } from "react-toastify";

export const showAndUploadFile = (e, callback, uploadEndPoint) => {
    const file = new FileReader();
    file.readAsDataURL(e.target.files[0]);

    file.onload = (e) => {
        callback(e.target.result);
    };

    const formdata = new FormData();
    formdata.append("avatar", e.target.files[0]);

    axios
        .post(uploadEndPoint, formdata)
        .then((res) => toast("Success"))
        .catch((err) => console.error(err));
};
