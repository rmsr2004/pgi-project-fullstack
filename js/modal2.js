function scrollToFormAndSelect(userType) {
    document.getElementById('formContainer').scrollIntoView({ behavior: 'smooth' });

    document.getElementById('userType').value = userType;
}

document.getElementById('btnQueroAlugar').addEventListener('click', function() {
    // redirect to login page
    window.location.href = "../login.php";
});

document.getElementById('btnQueroArrendar').addEventListener('click', function() {
    scrollToFormAndSelect('senhorio');
});