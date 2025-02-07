// Selecionando os elementos
const notaFiscalItems = document.querySelectorAll('.nota-fiscal .item');
const garantiaItems = document.querySelectorAll('.garantia .item');
const avancarButton = document.querySelector('.avanc input[type="submit"]');
const formFields = document.querySelectorAll('.txt_field input, .checkbox-group input[type="checkbox"]');

// Função para verificar se todos os campos obrigatórios estão preenchidos
function checkFormCompletion() {
    const allFilled = [...formFields].every(field => {
        if (field.type === 'checkbox') {
            return field.required ? field.checked : true; // Checkboxes obrigatórios devem estar marcados
        }
        return field.value.trim() !== ''; // Campos de texto devem estar preenchidos
    });

    if (allFilled) {
        avancarButton.style.backgroundColor = '#A739C0'; // Cor roxa
        avancarButton.disabled = false; // Habilitar o botão
    } else {
        avancarButton.style.backgroundColor = 'gray'; // Cor cinza
        avancarButton.disabled = true; // Desabilitar o botão
    }
}

// Adicionando eventos aos itens "Sim" e "Não"
notaFiscalItems.forEach(item => {
    item.addEventListener('click', () => {
        notaFiscalItems.forEach(i => i.classList.remove('active'));
        item.classList.add('active');
        document.getElementById(item.getAttribute('for')).checked = true;
        checkFormCompletion(); // Verifica se todos os campos estão preenchidos
    });
});

garantiaItems.forEach(item => {
    item.addEventListener('click', () => {
        garantiaItems.forEach(i => i.classList.remove('active'));
        item.classList.add('active');
        document.getElementById(item.getAttribute('for')).checked = true;
        checkFormCompletion(); // Verifica se todos os campos estão preenchidos
    });
});

// Adicionando eventos aos campos do formulário
formFields.forEach(field => {
    field.addEventListener('input', checkFormCompletion);
});

// Inicializa o estado do botão ao carregar
checkFormCompletion();
