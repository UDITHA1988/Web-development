const first_name = document.getElementById('first_name')
const last_name = document.getElementById('last_name')
const email = document.getElementById('email')
const password = document.getElementById('password')
const confirm = document.getElementById('confirm')
const form = document.getElementById('form')
const regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/


form.addEventListener('submit', (e) => {


    if (first_name.value === '' || first_name.value == null) {

        e.preventDefault()
        document.getElementById('h5_first_name').innerHTML = "First nameis reqired"
    } else {
        document.getElementById('h5_first_name').innerHTML = ""
    }

    if (last_name.value === '' || last_name.value == null) {

        e.preventDefault()
        document.getElementById('h5_last_name').innerHTML = "Last name is reqired"
    } else {
        document.getElementById('h5_last_name').innerHTML = ""
    }

    if (email.value === '' || email.value == null) {

        e.preventDefault()
        document.getElementById('h5_email').innerHTML = "E mail is reqired"

    } else if (!regex.test(email.value)) {

        document.getElementById('h5_email').innerHTML = "E mail is not valid"
        e.preventDefault()
    } else {
        document.getElementById('h5_email').innerHTML = ""
    }

    if (password.value === '' || password.value == null) {

        e.preventDefault()
        document.getElementById('h5_password').innerHTML = "Password is reqired"
    } else {
        document.getElementById('h5_password').innerHTML = ""
    }

    if (confirm.value != password.value) {

        e.preventDefault()
        document.getElementById('h5_confirm').innerHTML = "passwords dont match"
    } else {
        document.getElementById('h5_confirm').innerHTML = ""
    }

})