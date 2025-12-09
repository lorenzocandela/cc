const bacinella = document.getElementById('BACINELLA');
const bacinellanav = document.getElementById('BACINELLA-NAV');
//GLOBAL call per reg e ins

const inserimento = document.getElementById('INSERIMENTO');
const insertBtn = document.getElementById('INSERT');

insertBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    bacinella.classList.add('blurred');
    bacinellanav.classList.add('blurred');
    inserimento.style.display = 'block';
    void inserimento.offsetWidth; // forza reflow per attivare transizione
    inserimento.classList.add('show');
});

document.addEventListener('click', function (e) {
    if (
        inserimento.classList.contains('show') &&
        !inserimento.contains(e.target) &&
        e.target.id !== 'INSERT'
    ) {
        inserimento.classList.remove('show');
        bacinella.classList.remove('blurred');
        bacinellanav.classList.remove('blurred');
        setTimeout(() => {
            inserimento.style.display = 'none';
        }, 400);
    }
});

const registro = document.getElementById('REGISTRO');
const regBtn = document.getElementById('REGISTER');

regBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    bacinella.classList.add('blurred');
    bacinellanav.classList.add('blurred');
    registro.style.display = 'block';
    void registro.offsetWidth; // forza reflow per attivare transizione
    registro.classList.add('show');
});

document.addEventListener('click', function (e) {
    if (
        registro.classList.contains('show') &&
        !registro.contains(e.target) &&
        e.target.id !== 'INSERT'
    ) {
        registro.classList.remove('show');
        bacinella.classList.remove('blurred');
        bacinellanav.classList.remove('blurred');
        setTimeout(() => {
            registro.style.display = 'none';
        }, 400);
    }
});