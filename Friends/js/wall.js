const inputElement = document.getElementById('fileToUpload')
const form = document.getElementById('form')

form.addEventListener('submit', (e) => {


    if (inputElement.files.length == 0) {
        e.preventDefault()
        window.alert('A file is not selected')
    }

})