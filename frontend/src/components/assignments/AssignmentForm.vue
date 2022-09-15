<template>
  <v-container fluid>
    <v-data-table
      id="turnsTable"
      v-model="selected"
      show-select
      :headers="headers"
      :items="turns"
    >
      <template #[`item.status`]="{ item }">
        <div :class="{ 'red--text': !item.status }">
          {{ item.status ? 'Activo' : 'Inactivo' }}
        </div>
      </template>
    </v-data-table>

    <v-row>
      <v-col>
        {{ itinerary }}
        <v-menu
          ref="menu"
          v-model="menu"
          :close-on-content-click="false"
          :nudge-right="40"
          transition="scale-transition"
          offset-y
          min-width="auto"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
              v-model="itinerary"
              label="F. Publicacion"
              prepend-icon="mdi-clock-time-four-outline"
              readonly
              v-bind="attrs"
              v-on="on"
            ></v-text-field>
          </template>
          <v-date-picker v-model="itinerary" @input="menu = false">
          </v-date-picker>
        </v-menu>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-btn
          elevation="0"
          @click="save"
          dark
          outlined
          rounded
          small
          color="primary"
        >
          <v-icon dark class="mr-2"> mdi-content-save </v-icon> Guardar
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import moment from 'moment';
import { mapActions, mapState } from 'vuex';
export default {
  name: 'AssignmentForm',
  props: {
    movieId: {
      type: Number,
      required: true,
      default: null,
    },
  },
  data: () => ({
    selected: [],
    menu: false,
    itinerary: moment().format('YYYY-MM-DD'),
    headers: [
      {
        text: 'ID',
        align: 'start',
        sorteable: true,
        value: 'id',
      },
      {
        text: 'TURNO',
        align: 'start',
        sorteable: true,
        value: 'turn',
      },
      {
        text: 'ESTADO',
        align: 'start',
        sorteable: true,
        value: 'status',
      },
    ],
  }),
  methods: {
    async save() {
      if (this.selected.length === 0) {
        this.$swal.fire(
          'Error',
          'Debe seleccionar al menos un turno para ser asignado',
          'error'
        );
        return;
      }
      const payload = {
        movie_id: this.movieId,
        turn_ids: this.selected.map((item) => item.id),
        itinerary: this.itinerary,
      };
      const response = await this.saveAssignment(payload);
      if (response) {
        this.$swal.fire(
          'Felicidades',
          'El registro fue eliminado correctamente',
          'success'
        );
        this.$emit('refreshData');
        this.selected = [];
      }
    },
    ...mapActions(['saveAssignment']),
  },
  computed: {
    ...mapState({
      turns: (state) => state.items,
    }),
  },
};
</script>
