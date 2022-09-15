import movies from '../fixtures/movies.json';

const uuid = (+new Date() * Math.random()).toString(36).substring(0, 6);

describe('Movies section', () => {
  beforeEach(() => {
    cy.wait(5000);
    cy.intercept('**/api/login').as('login');
    cy.intercept(
      {
        method: 'GET',
        url: '**/api/movies/*',
      },
      movies
    ).as('getMovies');

    cy.intercept({
      method: 'DELETE',
      url: '**/api/movies/*',
    }).as('deleteMovie');

    cy.intercept({
      method: 'POST',
      url: '**/api/movies',
    }).as('postMovie');

    cy.login();
    cy.wait('@login');
  });

  it('Should show the list of movies', () => {
    cy.visit('/admin/movies');
    cy.get('div.v-avatar').should('be.visible');
    cy.get('#moviesTable').should('be.visible');
    cy.get('div.v-card__title').should('contain', 'Películas');
  });

  it('Should show form', () => {
    cy.visit('/admin/movie');
    cy.get('div.v-card__title').should('contain', 'Agregar  Pelicula');
  });

  it('Should show name error', () => {
    cy.visit('/admin/movie');
    cy.get('[data-cy="saveBtn"]').click();
    cy.get('div.v-messages__message').should(
      'contain',
      'El nombre es requerido'
    );
  });

  it('Should create a new movie', () => {
    cy.visit('/admin/movie');

    cy.get('[data-cy="nameInput"').type(uuid);
    cy.get('[data-cy="saveBtn"]').click();

    cy.wait('@postMovie').its('response.statusCode').should('eq', 200);
  });

  it('Should get 422 status code', () => {
    cy.visit('/admin/movie');

    cy.get('[data-cy="nameInput"').type(uuid);
    cy.get('[data-cy="saveBtn"]').click();
    cy.wait('@postMovie').its('response.statusCode').should('eq', 422);
  });

  it('Should show an error when try delete', () => {
    cy.visit('/admin/movies');
    cy.get('.deleteBtn').first().click();
    cy.get('#swal2-html-container').should('be.visible');
    cy.get('#swal2-html-container').should(
      'contain',
      'Este registro no se puede eliminar ya que tiene asignado uno o mas turnos'
    );
    cy.get('button.swal2-confirm.swal2-styled').click();
  });

  it('Should show confirm dialgo when try delete', () => {
    cy.visit('/admin/movies');
    cy.get('.deleteBtn').eq(1).click();
    cy.get('#swal2-html-container').should('be.visible');
    cy.get('#swal2-html-container').should(
      'contain',
      'Este cambio no se puede revertir'
    );
    cy.get('button.swal2-confirm.swal2-styled.swal2-default-outline').click();
    cy.wait('@deleteMovie').its('response.statusCode').should('eq', 200);
  });
});
