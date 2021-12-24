import React from 'react';
import ReactDOM from 'react-dom';

function Example({ comments }) {
    

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header">Hello wrold</div>

                        <div className="card-body">I'm an example component!</div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Example;



if (document.getElementById('example')) {

    const datafromblade = JSON.parse(
        document.getElementById("example").getAttribute("data")
    );
    
    
    ReactDOM.render(<Example comments={datafromblade}/>, document.getElementById('example'));
}
