export const fetchAllComment = async (threadid) => {


    const { data: response } = await axios
        .get("/comments/" + threadid)
        .catch((error) => console.log(error));


    return response;
    

}