import ReactDOM from "react-dom";
import { useState } from 'react';

const Notifications = () => {

  const [notis, setNotis] = useState([]);

  const fetchAllNotis = () => {
    axios
        .get("/api/notifications")
        .then(({ data }) => {
            console.log(data);
            setNotis(data);
        })
        .catch((e) => console.log(e));
  }

  return (
      <li className="nav-item">
          <button
              onClick={fetchAllNotis}
              className="nav-link"
              data-bs-toggle="modal"
              data-bs-target="#exampleModal"
          >
              Notifications
          </button>
          <div
              className="modal fade"
              id="exampleModal"
              tabIndex="-1"
              aria-labelledby="exampleModalLabel"
              aria-hidden="true"
          >
              <div className="modal-dialog">
                  <div className="modal-content">
                      <div className="modal-header">
                          <h5 className="modal-title" id="exampleModalLabel">
                              Notifications
                          </h5>
                          <button
                              type="button"
                              className="btn-close"
                              data-bs-dismiss="modal"
                              aria-label="Close"
                          ></button>
                      </div>
                      <div className="modal-body">
                          <div className="list-group">
                              {/* @forelse (auth()->user()->notifications as $noti) */}
                              {!!notis.length &&
                                  notis.map((noti, key) => (
                                      <form method="POST" key={key}>
                                          <button
                                              className="list-group-item list-group-item-action"
                                              aria-current="true"
                                          >
                                              <div className="d-flex w-100 justify-content-between">
                                                  <h5 className="mb-1">
                                                      {noti.message.message}
                                                  </h5>
                                                  <small>3 days ago</small>
                                              </div>

                                              <small>
                                                  at {noti.created_at}
                                              </small>
                                          </button>
                                      </form>
                                  ))}
                              {!notis.length && (
                                  <p>No New Notifications Yet.</p>
                              )}
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </li>
  );
}
export default Notifications;

const notiid = document.getElementById('noti');

if (notiid) {
  ReactDOM.render(<Notifications />, document.getElementById("noti"));
}