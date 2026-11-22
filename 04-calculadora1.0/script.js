
const currentDisplay = document.getElementById('current');
const previousDisplay = document.getElementById('previous');
const keys = document.querySelector('.keys');

let currentValue = '0';
let previousValue = '';
let operation = null;
let shouldResetDisplay = false;

function updateDisplay() {
    currentDisplay.textContent = currentValue.replace('.', ',');
    
    if (operation && previousValue !== '') {
        previousDisplay.textContent =
            `${previousValue.replace('.', ',')} ${getSymbol(operation)}`;
    } else {
        previousDisplay.textContent = '';
    }
}

function getSymbol(op) {
    const symbols = {
        add: '+',
        subtract: '−',
        multiply: '×',
        divide: '÷'
    };

    return symbols[op];
}

function addNumber(number) {
    if (currentValue === 'Erro') {
        clearCalculator();
    }

    if (shouldResetDisplay) {
        currentValue = number;
        shouldResetDisplay = false;
    } else {
        currentValue = currentValue === '0'
            ? number
            : currentValue + number;
    }

    updateDisplay();
}

function addDecimal() {
    if (currentValue === 'Erro') {
        clearCalculator();
    }

    if (shouldResetDisplay) {
        currentValue = '0';
        shouldResetDisplay = false;
    }

    if (!currentValue.includes('.')) {
        currentValue += '.';
    }

    updateDisplay();
}

function chooseOperation(selectedOperation) {
    if (currentValue === 'Erro') return;

    if (operation && !shouldResetDisplay) {
        calculate();
    }

    previousValue = currentValue;
    operation = selectedOperation;
    shouldResetDisplay = true;

    updateDisplay();
}

function calculate() {
    if (!operation || previousValue === '') return;

    const firstNumber = Number(previousValue);
    const secondNumber = Number(currentValue);

    let result;

    switch (operation) {
        case 'add':
            result = firstNumber + secondNumber;
            break;

        case 'subtract':
            result = firstNumber - secondNumber;
            break;

        case 'multiply':
            result = firstNumber * secondNumber;
            break;

        case 'divide':
            if (secondNumber === 0) {
                currentValue = 'Erro';
                previousValue = '';
                operation = null;
                shouldResetDisplay = true;
                updateDisplay();
                return;
            }

            result = firstNumber / secondNumber;
            break;
    }

    if (!Number.isFinite(result)) {
        currentValue = 'Erro';
    } else {
        // Evita resultados com excesso de casas decimais.
        currentValue = String(Number(result.toPrecision(12)));
    }

    previousValue = '';
    operation = null;
    shouldResetDisplay = true;

    updateDisplay();
}

function clearCalculator() {
    currentValue = '0';
    previousValue = '';
    operation = null;
    shouldResetDisplay = false;

    updateDisplay();
}

function deleteNumber() {
    if (currentValue === 'Erro' || shouldResetDisplay) {
        currentValue = '0';
        shouldResetDisplay = false;
    } else {
        currentValue = currentValue.length > 1
            ? currentValue.slice(0, -1)
            : '0';

        if (currentValue === '-') currentValue = '0';
    }

    updateDisplay();
}

function calculatePercent() {
    if (currentValue === 'Erro') return;

    currentValue = String(Number(currentValue) / 100);
    shouldResetDisplay = true;

    updateDisplay();
}

keys.addEventListener('click', function(event) {
    const button = event.target.closest('button');

    if (!button) return;

    if (button.dataset.number !== undefined) {
        addNumber(button.dataset.number);
        return;
    }

    if (button.dataset.operation) {
        chooseOperation(button.dataset.operation);
        return;
    }

    switch (button.dataset.action) {
        case 'clear':
            clearCalculator();
            break;

        case 'delete':
            deleteNumber();
            break;

        case 'decimal':
            addDecimal();
            break;

        case 'calculate':
            calculate();
            break;

        case 'percent':
            calculatePercent();
            break;
    }
});

// Atalhos pelo teclado
document.addEventListener('keydown', function(event) {
    const key = event.key;

    if (/^[0-9]$/.test(key)) {
        addNumber(key);
    } else if (key === '.' || key === ',') {
        addDecimal();
    } else if (key === '+') {
        chooseOperation('add');
    } else if (key === '-') {
        chooseOperation('subtract');
    } else if (key === '*') {
        chooseOperation('multiply');
    } else if (key === '/') {
        event.preventDefault();
        chooseOperation('divide');
    } else if (key === 'Enter' || key === '=') {
        calculate();
    } else if (key === 'Backspace') {
        deleteNumber();
    } else if (key === 'Escape') {
        clearCalculator();
    } else if (key === '%') {
        calculatePercent();
    }
});

updateDisplay();
