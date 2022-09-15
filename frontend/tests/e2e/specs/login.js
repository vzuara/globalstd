describe('Login page', () => {
  beforeEach(() => {
    cy.clearLocalStorage('token');
    cy.visit('/');
  });

  it('Should show the form', () => {
    cy.get('[data-cy="logo"]').should('be.visible');
    cy.get('[data-cy="emailInput"]').should('be.visible');
    cy.get('[data-cy="passwordInput"]').should('be.visible');
  });

  it('Should log into the system', () => {
    cy.get('[data-cy="emailInput"]').type('test@example.com');
    cy.get('[data-cy="passwordInput"]').type('password');
    cy.get('[data-cy="loginBtn"]').click();
    cy.url().should('have.contain', '/admin');
  });

  it('Should not log into the system', () => {
    cy.get('[data-cy="emailInput"]').type('test@example.com');
    cy.get('[data-cy="passwordInput"]').type('password123');
    cy.get('[data-cy="loginBtn"]').click();

    cy.get('#swal2-html-container').should('be.visible');
    cy.get('#swal2-html-container').should(
      'contain',
      'Sus datos son incorrectos favor de verificar'
    );

    expect(localStorage.getItem('token')).to.be.null;
  });
});
