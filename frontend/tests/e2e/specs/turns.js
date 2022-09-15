import turns from '../fixtures/turns.json';

describe('Turns section', () => {
  beforeEach(() => {
    cy.wait(5000);
    cy.intercept('**/api/login').as('login');
    cy.intercept(
      {
        method: 'GET',
        url: '**/api/turns/*',
      },
      turns
    ).as('getTurns');

    cy.intercept({
      method: 'DELETE',
      url: '**/api/turns/*',
    }).as('deleteTurn');

    cy.intercept({
      method: 'POST',
      url: '**/api/turns',
    }).as('postTurn');

    cy.login();
    cy.wait('@login');
  });

  it('Should show the list of turns', () => {
    cy.visit('/admin/turns');
    cy.get('div.v-avatar').should('be.visible');
    cy.get('#turnsTable').should('be.visible');
    cy.get('div.v-card__title').should('contain', 'Turnos');
  });

  it('Should show form', () => {
    cy.visit('/admin/turn');
    cy.get('div.v-card__title').should('contain', 'Agregar Turno');
  });

  it('Should create a new turn', () => {
    cy.visit('/admin/turn');
    cy.get('[data-cy="saveBtn"]').click();

    cy.wait('@postTurn').its('response.statusCode').should('eq', 200);
  });

  it('Should get 422 status code', () => {
    cy.visit('/admin/turn');

    cy.get('[data-cy="saveBtn"]').click();
    cy.wait('@postTurn').its('response.statusCode').should('eq', 422);
  });

  it('Should show an error when try delete', () => {
    cy.visit('/admin/turns');
    cy.get('.deleteBtn').first().click();
    cy.get('#swal2-html-container').should('be.visible');
    cy.get('#swal2-html-container').should(
      'contain',
      'Este registro no se puede eliminar ya que esta asignado a una o mas peliculas'
    );
    cy.get('button.swal2-confirm.swal2-styled').click();
  });

  it('Should show confirm dialgo when try delete', () => {
    cy.visit('/admin/turns');
    cy.get('.deleteBtn').eq(1).click();
    cy.get('#swal2-html-container').should('be.visible');
    cy.get('#swal2-html-container').should(
      'contain',
      'Este cambio no se puede revertir'
    );
    cy.get('button.swal2-confirm.swal2-styled.swal2-default-outline').click();
    cy.wait('@deleteTurn').its('response.statusCode').should('eq', 200);
  });
});
