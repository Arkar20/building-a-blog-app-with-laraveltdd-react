import ReactDOM from "react-dom";
import {useState} from "react"
const Subscribe = ({ thread }) => {


  const [issubscribe, setIssubscribe] = useState(thread.is_subscribed);
  
  const handleSubscribe = (e) => {
    e.preventDefault();
    // thread / { thread: id } / subscribe;
    axios
        .post("/thread/" + thread.id + "/subscribe")
      .then((res) => {
         setIssubscribe(!issubscribe);
        
        })
        .catch((err) => console.log(err));
  }
    return (
        <div>
            {isAuth && <form className="m-2" method="POST" onSubmit={handleSubscribe}>
                <button
                    className={`btn ${
                        issubscribe ? "btn-primary" : "btn-dark"
                    }`}
                >
                    {issubscribe ? "Unsubscribe" : "Subscribe"}
                </button>
            </form>
            }
        </div>
    );
}

export default Subscribe;

const subscribeid = document.getElementById("subscribe");

if (subscribeid) {
    const thread = JSON.parse(
        document.getElementById("subscribe").getAttribute("thread")
    );

    ReactDOM.render(
        <Subscribe thread={thread} />,
        document.getElementById("subscribe")
    );
}