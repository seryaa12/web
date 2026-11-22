// Projeto 02 — Currículo
// Permite imprimir ou salvar o currículo em PDF pelo navegador.
const printButton = document.querySelector("#printResume");

if (printButton) {
  printButton.addEventListener("click", () => {
    window.print();
  });
}
