
const form = document.getElementById('registrationForm');
const participantsList = document.getElementById('participantsList');
const participantCount = document.getElementById('participantCount');
const confirmation = document.getElementById('confirmation');
const exportButton = document.getElementById('exportButton');

let participants = JSON.parse(localStorage.getItem('participantesCorrida')) || [];

function salvarDados() {
    localStorage.setItem('participantesCorrida', JSON.stringify(participants));
}

function gerarNumero() {
    // Usa o maior número já registrado para evitar duplicidade.
    const maiorNumero = participants.reduce((maior, participante) => {
        return Math.max(maior, Number(participante.numero));
    }, -1);

    return maiorNumero + 1;
}

function formatarNumero(numero) {
    return String(numero).padStart(4, '0');
}

function limparCPF(cpf) {
    return cpf.replace(/\D/g, '');
}

function validarCPF(cpf) {
    cpf = limparCPF(cpf);

    if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
        return false;
    }

    let soma = 0;

    for (let i = 0; i < 9; i++) {
        soma += Number(cpf[i]) * (10 - i);
    }

    let digito1 = (soma * 10) % 11;
    if (digito1 === 10) digito1 = 0;

    if (digito1 !== Number(cpf[9])) return false;

    soma = 0;

    for (let i = 0; i < 10; i++) {
        soma += Number(cpf[i]) * (11 - i);
    }

    let digito2 = (soma * 10) % 11;
    if (digito2 === 10) digito2 = 0;

    return digito2 === Number(cpf[10]);
}

function renderizarParticipantes() {
    participantCount.textContent =
        `${participants.length} inscrito${participants.length === 1 ? '' : 's'}`;

    if (participants.length === 0) {
        participantsList.innerHTML = `
            <tr>
                <td colspan="4" class="empty">Nenhuma inscrição realizada.</td>
            </tr>
        `;
        return;
    }

    participantsList.innerHTML = participants.map(participante => `
        <tr>
            <td>${formatarNumero(participante.numero)}</td>
            <td>${escaparHTML(participante.nome)}</td>
            <td>${escaparHTML(participante.categoria)}</td>
            <td>${participante.dataInscricao}</td>
        </tr>
    `).join('');
}

function escaparHTML(valor) {
    return String(valor).replace(/[&<>"']/g, caractere => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    })[caractere]);
}

form.addEventListener('submit', function(event) {
    event.preventDefault();

    const nome = document.getElementById('name').value.trim();
    const cpf = document.getElementById('cpf').value;
    const nascimento = document.getElementById('birth').value;
    const email = document.getElementById('email').value.trim();
    const telefone = document.getElementById('phone').value.trim();
    const categoria = document.getElementById('category').value;

    if (!validarCPF(cpf)) {
        alert('Informe um CPF válido.');
        return;
    }

    const cpfLimpo = limparCPF(cpf);

    if (participants.some(p => p.cpf === cpfLimpo)) {
        alert('Este CPF já possui uma inscrição.');
        return;
    }

    if (new Date(nascimento) >= new Date()) {
        alert('A data de nascimento deve ser anterior à data atual.');
        return;
    }

    const novoParticipante = {
        numero: gerarNumero(),
        nome,
        cpf: cpfLimpo,
        nascimento,
        email,
        telefone,
        categoria,
        dataInscricao: new Date().toLocaleDateString('pt-BR')
    };

    participants.push(novoParticipante);
    salvarDados();
    renderizarParticipantes();

    confirmation.classList.remove('hidden');
    confirmation.innerHTML = `
        <strong>Inscrição realizada com sucesso!</strong><br>
        Participante: ${escaparHTML(nome)}<br>
        Número de identificação:
        <strong>${formatarNumero(novoParticipante.numero)}</strong><br>
        Categoria: ${escaparHTML(categoria)}
    `;

    form.reset();
    confirmation.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
});

exportButton.addEventListener('click', function() {
    if (participants.length === 0) {
        alert('Não existem inscrições para exportar.');
        return;
    }

    const cabecalho = [
        'Número',
        'Nome',
        'CPF',
        'Nascimento',
        'Email',
        'Telefone',
        'Categoria',
        'Data da inscrição'
    ];

    const linhas = participants.map(p => [
        formatarNumero(p.numero),
        p.nome,
        p.cpf,
        p.nascimento,
        p.email,
        p.telefone,
        p.categoria,
        p.dataInscricao
    ]);

    const csv = [cabecalho, ...linhas]
        .map(linha => linha.map(valor =>
            `"${String(valor).replace(/"/g, '""')}"`
        ).join(';'))
        .join('\n');

    const arquivo = new Blob(
        ['\uFEFF' + csv],
        { type: 'text/csv;charset=utf-8;' }
    );

    const link = document.createElement('a');
    const url = URL.createObjectURL(arquivo);

    link.href = url;
    link.download = 'inscricoes-maratona.csv';
    link.click();

    URL.revokeObjectURL(url);
});

renderizarParticipantes();
