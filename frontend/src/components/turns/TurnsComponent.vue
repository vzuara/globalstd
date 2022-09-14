<template>
  <v-card>
    <v-card-title>
      Turnos
      <v-spacer></v-spacer>

      <v-btn
        elevation="0"
        @click="addItem"
        dark
        outlined
        rounded
        small
        color="primary"
      >
        <v-icon dark class="mr-2"> mdi-plus </v-icon> Nuevo Turno
      </v-btn>
    </v-card-title>
    <v-data-table
      id="beersTable"
      :headers="headers"
      :items="turns"
      :options.sync="options"
      :server-items-length="totalTurns"
      :loading="loading"
    >
      <template #[`item.status`]="{ item }">
        <div :class="{ 'red--text': !item.status }">
          {{ item.status ? 'Activo' : 'Inactivo' }}
        </div>
      </template>
      <template #[`item.actions`]="{ item }">
        <ActionButton
          @action="editItem(item.id)"
          :color="'primary'"
          :icon="'mdi-pencil'"
          :tooltip="'Editar'"
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
import ActionButton from './../ui/actionButton.vue';
import { mapState, mapActions, mapMutations } from 'vuex';
import moment from 'moment';
export default {
  name: 'TurnsComponent',
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
        text: 'Turno',
        align: 'start',
        sorteable: true,
        value: 'turn',
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
    this.getTurns();
  },
  methods: {
    addItem() {
      this.setTurn({
        turn: moment().format('HH:mm'),
        status: false,
      });
      this.$router.push({ name: 'Turn' });
    },
    editItem(id) {
      this.$router.push({ name: 'Turn', query: { id } });
    },
    deleteItem(item) {
      if (item.movies.length > 0) {
        this.$swal.fire(
          'Error',
          'Este registro no se puede eliminar ya que esta asignado a una o mas peliculas',
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
            this.deleteTurn(item.id);
          }
        });
    },
    ...mapActions(['getTurns', 'deleteTurn']),
    ...mapMutations([
      'resetState',
      'setLoading',
      'setPage',
      'setItemsPerPage',
      'setSortBy',
      'setSortDesc',
      'setTurn',
    ]),
  },
  computed: mapState({
    turns: (state) => state.items,
    totalTurns: (state) => state.totalItems,
    loading: (state) => state.loading,
  }),
  watch: {
    turns: {
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
        this.getTurns();
      },
      deep: true,
    },
  },
};
</script>
