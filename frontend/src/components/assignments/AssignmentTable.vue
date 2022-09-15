<template>
  <v-data-table
    id="turnAssignedTable"
    :headers="headers"
    :items="turns"
    :item-key="`id-${Date.now()}`"
  >
    <template #[`item.status`]="{ item }">
      <div :class="{ 'red--text': !item.status }">
        {{ item.status ? 'Activo' : 'Inactivo' }}
      </div>
    </template>

    <template #[`item.actions`]="{ item }">
      <ActionButton
        @action="deassign(item.id)"
        :color="'error'"
        :icon="'mdi-delete'"
        :tooltip="'Desasignar turno'"
      />
    </template>
  </v-data-table>
</template>

<script>
import ActionButton from './../ui/actionButton.vue';
import { mapActions } from 'vuex';
export default {
  name: 'AssignmentTable',
  components: {
    ActionButton,
  },
  props: {
    items: {
      type: Array,
      required: true,
      default: () => [],
    },
    movieId: {
      type: Number,
      required: true,
      default: null,
    },
  },
  data: () => ({
    turns: [],
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
      {
        text: 'ITINEARARIO',
        align: 'start',
        sorteable: true,
        value: 'pivot.itinerary',
      },
      { text: 'Actions', value: 'actions', sortable: false, width: '200px' },
    ],
  }),
  mounted() {
    this.turns = [...this.items];
  },
  methods: {
    deassign(val) {
      this.$swal
        .fire({
          title: 'Esta seguro?',
          text: 'Este cambio no se puede revertir',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, desasignalo',
        })
        .then(async (result) => {
          if (result.isConfirmed) {
            const payload = {
              movie_id: this.movieId,
              turn_id: val,
            };
            const response = await this.deleteAssignment(payload);
            if (response) {
              this.$emit('refreshData');
              this.$swal.fire(
                'Felicidades',
                'El registro fue eliminado correctamente',
                'success'
              );
            }
          }
        });
    },
    ...mapActions(['deleteAssignment']),
  },
  watch: {
    items(newVal) {
      this.turns = [...newVal];
    },
  },
};
</script>
