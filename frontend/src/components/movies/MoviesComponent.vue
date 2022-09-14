<template>
  <v-card>
    <v-card-title
      >Películas <v-spacer></v-spacer>

      <v-btn
        elevation="0"
        @click="addItem"
        dark
        outlined
        rounded
        small
        color="primary"
      >
        <v-icon dark class="mr-2"> mdi-plus </v-icon> Nueva Película
      </v-btn></v-card-title
    >
    <v-data-table
      id="beersTable"
      :headers="headers"
      :items="movies"
      :options.sync="options"
      :server-items-length="totalMovies"
      :loading="loading"
    >
      <template #[`item.status`]="{ item }">
        <div :class="{ 'red--text': !item.status }">
          {{ item.status ? 'Activo' : 'Inactivo' }}
        </div>
      </template>
      <template #[`item.image`]="{ item }">
        <span v-if="item.image">
          <v-img
            max-height="150"
            max-width="250"
            :src="`http://localhost:8000/${item.image.replace(
              'public',
              'storage'
            )}`"
          />
        </span>
      </template>

      <template #[`item.actions`]="{ item }">
        <ActionButton
          @action="editItem(item.id)"
          :color="'primary'"
          :icon="'mdi-pencil'"
          :tooltip="'Editar'"
        />

        <ActionButton
          @action="assignTurns(item.id)"
          :color="'primary'"
          :icon="'mdi-menu'"
          :tooltip="'Asignar turnos'"
        />

        <ActionButton :color="'secondary'" :icon="'mdi-lock'" :tooltip="''" />
        <ActionButton
          @action="deleteItem(item)"
          :color="'error'"
          :icon="'mdi-delete'"
          :tooltip="'Eliminar'"
        />
      </template> </v-data-table
  ></v-card>
</template>

<script>
import moment from 'moment';
import ActionButton from './../ui/actionButton.vue';
import { mapState, mapActions, mapMutations } from 'vuex';
export default {
  name: 'MoviesComponent',
  components: {
    ActionButton,
  },
  data: () => ({
    options: {},
    headers: [
      {
        text: 'ID',
        align: 'start',
        sorteable: true,
        value: 'id',
      },
      {
        text: 'Nombre',
        align: 'start',
        sorteable: true,
        value: 'name',
      },
      {
        text: 'Imagen',
        align: 'start',
        sorteable: false,
        value: 'image',
      },
      {
        text: 'F. Publicacion',
        align: 'start',
        sorteable: true,
        value: 'published_at',
      },
      {
        text: 'Estado',
        align: 'start',
        sorteable: true,
        value: 'status',
      },
      { text: 'Actions', value: 'actions', sortable: false, width: '200px' },
    ],
  }),
  mounted() {
    this.resetState();
    this.setLoading(true);
    this.getMovies();
  },
  methods: {
    addItem() {
      this.setMovie({
        name: null,
        published_at: moment().format('YYYY-MM-DD'),
        status: false,
        image: null,
      });
      this.$router.push({ name: 'Movie' });
    },
    editItem(id) {
      this.$router.push({ name: 'Movie', query: { id } });
    },
    deleteItem(item) {
      if (item.turns.length > 0) {
        this.$swal.fire(
          'Error',
          'Este registro no se puede eliminar ya que tiene asignado uno o mas turnos',
          'error'
        );
        return;
      }
      this.$swal
        .fire({
          title: 'Esta seguro?',
          text: 'Este cambio no se puede revertir',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminalo',
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.deleteMovie(item.id);
          }
        });
    },
    assignTurns(id) {
      this.$router.push({ name: 'Assignment', query: { id } });
    },
    ...mapActions(['getMovies', 'deleteMovie']),
    ...mapMutations([
      'resetState',
      'setLoading',
      'setPage',
      'setItemsPerPage',
      'setSortBy',
      'setSortDesc',
      'setMovie',
    ]),
  },
  computed: mapState({
    movies: (state) => state.items,
    totalMovies: (state) => state.totalItems,
    loading: (state) => state.loading,
  }),
  watch: {
    movies: {
      handler() {
        this.setLoading(false);
      },
    },
    options: {
      handler({ page, itemsPerPage, sortBy, sortDesc }) {
        this.setPage(page);
        this.setItemsPerPage(itemsPerPage);
        this.setSortBy(sortBy);
        this.setSortDesc(sortDesc);
        this.getMovies();
      },
      deep: true,
    },
  },
};
</script>
