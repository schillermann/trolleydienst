let firstname = document.getElementById('firstname');
let lastname = document.getElementById('lastname');
let username = document.getElementById('username');

function insertUsername() {
    username.value = (firstname.value + ' ' + lastname.value).toLowerCase();
}