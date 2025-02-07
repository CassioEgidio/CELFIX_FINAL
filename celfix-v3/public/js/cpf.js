function formatCPF(cpf) {
    cpf = cpf.replace(/[^\d]/g, ''); // Remove caracteres não numéricos
    if (cpf.length <= 3) return cpf;
    if (cpf.length <= 6) return cpf.replace(/(\d{3})(\d+)/, '$1.$2');
    if (cpf.length <= 9) return cpf.replace(/(\d{3})(\d{3})(\d+)/, '$1.$2.$3');
    return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
}

document.addEventListener('DOMContentLoaded', function() {
    const cpfInput = document.getElementById('cpf');

    cpfInput.addEventListener('input', function() {
        cpfInput.value = formatCPF(cpfInput.value);
    });
});