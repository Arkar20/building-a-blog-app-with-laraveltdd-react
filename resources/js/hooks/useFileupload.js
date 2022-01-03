import { useState } from "react";

const useFileupload = (e) => {
    const [percentage, setPercentage] = useState(0);

    const formdata = new FormData();
    formdata.append("avatar", e.target.files[0]);
    axios
        .post("/profile/" + auth.name + "/avatar", formdata, {
            onUploadProgress: (progressEvent) =>
                setPercentage(progressEvent.loaded),
        })
        .then((res) => {
            toast("Successful");
        })
        .catch((err) => console.error(err));
    
    return {percentage}
};
