function defaultHandler(response) {

    if (response.status !== 200) {
        if (response.message) {
            if (typeof response.message === 'string') {
                alert(response.message);
            } else {
                alert(JSON.stringify(response.message));
            }
        } else {
            alert('Error: ' + response.status);
        }
    } else {
        if (response.token) {
            setToken(response.token);
        }
        let redirect = response.redirect;
        if (!redirect) {
            return;
        }
        window.location.href = redirect;
    }
    try{
        document.getElementById("submit").disabled = false;
    }catch (e) {
    }
}
function xhrOnLoad(callback, xhr){
    return function() {
        try {
            let res = JSON.parse(xhr.responseText);
            res.status = xhr.status;
            callback(res);
        } catch (e) {
            document.innerHTML = xhr.responseText;
        }
    }
}
function request(url, data, method, callback){
    const xhr = new XMLHttpRequest();
    if (!callback || typeof callback !== 'function') {
        callback = defaultHandler;
    }
    //convert data to json if it is not already
    if (typeof data === 'object') {
        data = JSON.stringify(data);
    }
    xhr.open(method, url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    const token = getToken();
    if (token) {
        xhr.setRequestHeader('Authorization', token);
    }
    xhr.onload = xhrOnLoad(callback, xhr);
    xhr.send(data);

}
function post(url, data, callback) {
    request(url, data, 'POST', callback);
}

function get(url, callback) {
    request(url, null, 'GET', callback);
}

//mmm should merge these function
function put(url, data, callback) {
    request(url, data, 'PUT', callback);
}



function getToken() {
    return sessionStorage.getItem('token') || localStorage.getItem('token');
}

function setToken(token) {
    const field = document.getElementById('remember');
    const remember = field ? field.checked : true;
    if (remember) {
        localStorage.setItem('token', token);
    } else {
        sessionStorage.setItem('token', token);
    }
}

function loginByForm(button) {
    button.disabled = 'disabled';
    post('/api/login', {
        email: document.getElementById('email').value,
        password: document.getElementById('password').value,
        remember: document.getElementById('remember').checked// ???
    }, function(response){
        defaultHandler(response);
        button.disabled = false;
    });
}

function registerByForm(button) {
    button.disabled = 'disabled';
    post('/api/register', {
        name: document.getElementById('username').value,
        email: document.getElementById('email_address').value,
        phone: document.getElementById('phone').value,
        password: document.getElementById('password').value,
        password_confirmation: document.getElementById('password_confirmation').value,
        remember: true// ????
    }, function(response){
        defaultHandler(response);
        button.disabled = false;
    });
}



function setDashboardContent() {
    const username = document.getElementById("username");
    const email = document.getElementById("email");
    const phone = document.getElementById("phone");
    const token = getToken();
    if (token) {
        put('/api/user', {
            token: token,
            username: username.value,
            email: email.value,
            phone: phone.value
        }, function (response) {
            if (response.status === 200) {
                username.value = response.data.username;
                email.value = response.data.email;
                phone.value = response.data.phone;
                alert("Successfully updated");
            } else {
                defaultHandler(response);
            }
        });
    }else{
     alert("No Token");
    }
}

function refreshDashboardContent() {

    get('/api/user',
        function (response) {
            if (response.status === 200) {
                const username = document.getElementById("username");
                const email = document.getElementById("email");
                const phone = document.getElementById("phone");
                username.value = response.data.username;
                email.value = response.data.email;
                phone.value = response.data.phone;
                return
            }
            defaultHandler(response);
        });

}

//assuming we are in /dashboard
if (getToken()) {
    document.getElementById("login").hidden = true;
    document.getElementById("logout").hidden = false;
    refreshDashboardContent()

} else {
    document.getElementById("login").hidden = false;
    document.getElementById("logout").hidden = true;
    document.getElementById("content").innerHTML = "<h1>Please Login</h1>";
    window.location.href = "/login";
}


