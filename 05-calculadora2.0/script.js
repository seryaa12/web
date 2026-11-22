
const form = document.getElementById('equationForm');

const resultArea = document.getElementById('result');
const deltaValue = document.getElementById('deltaValue');
const root1 = document.getElementById('root1');
const root2 = document.getElementById('root2');
const rootStatus = document.getElementById('rootStatus');
const explanationText = document.getElementById('explanationText');

function formatarNumero(numero) {
    if (!Number.isFinite(numero)) return '—';

    // Remove pequenas imprecisões de ponto flutuante.
    const valor = Number(numero.toPrecision(10));

    return valor.toLocaleString('pt-BR', {
        maximumFractionDigits: 8
    });
}

function mostrarResultado(delta, x1, x2, status, explicacao) {
    resultArea.classList.remove('hidden');

    deltaValue.textContent = formatarNumero(delta);
    root1.textContent = x1;
    root2.textContent = x2;
    rootStatus.textContent = status;
    explanationText.textContent = explicacao;

    resultArea.scrollIntoView({
        behavior: 'smooth',
        block: 'nearest'
    });
}

form.addEventListener('submit', function(event) {
    event.preventDefault();

    const a = Number(document.getElementById('coefficientA').value);
    const b = Number(document.getElementById('coefficientB').value);
    const c = Number(document.getElementById('coefficientC').value);

    // O coeficiente A não pode ser zero.
    if (a === 0) {
        alert('O coeficiente A deve ser diferente de zero. Caso contrário, a equação não será de segundo grau.');
        return;
    }

    // Cálculo do discriminante.
    const delta = (b * b) - (4 * a * c);

    if (delta > 0) {
        // Duas raízes reais diferentes.
        const x1 = (-b + Math.sqrt(delta)) / (2 * a);
        const x2 = (-b - Math.sqrt(delta)) / (2 * a);

        mostrarResultado(
            delta,
            formatarNumero(x1),
            formatarNumero(x2),
            'DUAS RAÍZES REAIS',
            'O discriminante é positivo. Portanto, a equação possui duas raízes reais e distintas.'
        );

    } else if (delta === 0) {
        // Uma raiz real dupla.
        const x = -b / (2 * a);

        mostrarResultado(
            delta,
            formatarNumero(x),
            formatarNumero(x),
            'UMA RAIZ REAL DUPLA',
            'O discriminante é igual a zero. Portanto, a equação possui duas raízes reais iguais.'
        );

    } else {
        // Não existem raízes no conjunto dos números reais.
        mostrarResultado(
            delta,
            'Não existe',
            'Não existe',
            'SEM RAÍZES REAIS',
            'O discriminante é negativo. Portanto, a equação não possui raízes reais. Ela possui duas raízes complexas conjugadas.'
        );
    }
});

// Limpa os resultados quando o formulário é reiniciado.
form.addEventListener('reset', function() {
    resultArea.classList.add('hidden');

    deltaValue.textContent = '—';
    root1.textContent = '—';
    root2.textContent = '—';
    rootStatus.textContent = '';
    explanationText.textContent = '';
});
