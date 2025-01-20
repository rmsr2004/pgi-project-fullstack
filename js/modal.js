function scrollToFormAndSelect(userType) {
    document.getElementById('formContainer').scrollIntoView({ behavior: 'smooth' });

    document.getElementById('userType').value = userType;
}

document.getElementById('btnQueroAlugar').addEventListener('click', function() {
    scrollToFormAndSelect('inquilino');
});

document.getElementById('btnQueroArrendar').addEventListener('click', function() {
    scrollToFormAndSelect('senhorio');
});

document.getElementById('userForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const userType = document.getElementById('userType').value;

    const user = { name, email, userType };

    let users = JSON.parse(localStorage.getItem('users')) || [];  // Caso não haja, inicializa com um array vazio

    users.push(user);

    localStorage.setItem('users', JSON.stringify(users));

    let clickCount = localStorage.getItem('clickCount');
    clickCount = clickCount ? parseInt(clickCount) : 0;

    clickCount++;

    localStorage.setItem('clickCount', clickCount);
});
