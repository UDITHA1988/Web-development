const email = document.getElementById('email')
const password = document.getElementById('password')
const form = document.getElementById('form')
const regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/


form.addEventListener('submit', (e) => {


    if (email.value === '' || email.value == null) {

        e.preventDefault()
        document.getElementById('h5_email').innerHTML = "E mail is reqired"

    } else if (!regex.test(email.value)) {
        e.preventDefault()
        document.getElementById('h5_email').innerHTML = "E mail is not valid"
    } else {
        document.getElementById('h5_email').innerHTML = ""
    }

    if (password.value === '' || password.value == null) {

        e.preventDefault()
        document.getElementById('h5_password').innerHTML = "Password is reqired"
    } else {
        document.getElementById('h5_password').innerHTML = ""
    }



})