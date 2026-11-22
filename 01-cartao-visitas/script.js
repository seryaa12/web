// Cartão de visitas — interações adicionais podem ser implementadas aqui.
document.addEventListener("DOMContentLoaded", () => {
  const externalLinks = document.querySelectorAll('a[target="_blank"]');

  externalLinks.forEach((link) => {
    link.addEventListener("click", () => {
      // Os links externos já usam rel="noopener noreferrer" por segurança.
    });
  });
});
