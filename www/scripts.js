function register()
{  

    document.getElementById('loginError').innerHTML = '';
    document.getElementById('passwordError').innerHTML = '';
    document.getElementById('confirmPasswordError').innerHTML = '';
    document.getElementById('emailError').innerHTML = '';
    document.getElementById('nameError').innerHTML = '';

    let login           = document.getElementById('login').value;
    let password        = document.getElementById('password').value;
    let confirmPassword = document.getElementById('confirmPassword').value;
    let email           = document.getElementById('email').value;
    let name            = document.getElementById('name').value;

    let params = new URLSearchParams(); 
    params.set('login', login);
    params.set('password', password);
    params.set('confirmPassword', confirmPassword);
    params.set('email', email);
    params.set('name', name);

    fetch('/users/register', 
    {
        credentials: 'same-origin' ,
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        method: 'POST',
        body: params,
    }
    ).then(
        response => 
        {
            return response.json();
        }
    ).then(
    text => 
        {
        let error = Object.values(text);
        let type = error[0];
        let message = error[1];
        if(type === 'result')
        {
            redirect('/users/login');
        }
        document.getElementById(type).innerHTML = message;

    }
    );
}

function login()
{  

    document.getElementById('loginError').innerHTML = '';
    document.getElementById('passwordError').innerHTML = '';

    let login           = document.getElementById('login').value;
    let password        = document.getElementById('password').value;

    let params = new URLSearchParams(); 
    params.set('login', login);
    params.set('password', password);

    fetch('/users/login', 
    {
        credentials: 'same-origin' ,
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        method: 'POST',
        body: params,
    }
    ).then(
        response => 
        {
            return response.json();
        }
    ).then(
    text => 
        {
        
        let error = Object.values(text);
        let type = error[0];
        let message = error[1];

        if(type === 'main')
        {
            redirect('/');
        }

        document.getElementById(type).innerHTML = message;
    }
    );
}

function logout() 
{

    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;";
        document.cookie = name + '=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }
    redirect('/users/login');
}

function redirect(place)
{
    window.location.href = place;
}