var xhr = new XMLHttpRequest();
xhr.open("GET", "http://localhost/app_dev.php/user/api/organisations/133", false);
xhr.send();

console.log(xhr.status);
console.log(xhr.response);