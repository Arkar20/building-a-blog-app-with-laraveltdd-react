import { toast } from "react-toastify";

export const showAndUploadFile = (e, callback, name) => {
    const file = new FileReader();
    file.readAsDataURL(e.target.files[0]);

    file.onload = (e) => {
        callback(e.target.result);
    };

    const formdata = new FormData();
    formdata.append("avatar", e.target.files[0]);

    axios
        .post("/profile/" + name + "/avatar", formdata)
        .then((res) => toast("Success"))
        .catch((err) => console.error(err));
};
