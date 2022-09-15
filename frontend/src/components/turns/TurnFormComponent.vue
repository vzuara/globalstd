<template>
  <v-card>
    <v-card-title> {{ title }} Turno </v-card-title>
    <v-card-text>
      <v-container>
        <v-row>
          <v-col>
            <v-menu
              ref="menu"
              v-model="menu"
              :close-on-content-click="false"
              :nudge-right="40"
              :return-value.sync="item.turn"
              transition="scale-transition"
              offset-y
              max-width="290px"
              min-width="290px"
              required
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  v-model="item.turn"
                  label="Turno"
                  prepend-icon="mdi-clock-time-four-outline"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                ></v-text-field>
              </template>
              <v-time-picker
                v-if="menu"
                v-model="item.turn"
                full-width
                @click:minute="$refs.menu.save(item.turn)"
              ></v-time-picker>
            </v-menu>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-checkbox v-model="item.status" label="Activo?"></v-checkbox>
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
              data-cy="saveBtn"
            >
              <v-icon dark class="mr-2"> mdi-content-save </v-icon> Guardar
            </v-btn>
          </v-col>
        </v-row>
      </v-container>
    </v-card-text>
  </v-card>
</template>

<script>
import moment from 'moment';
import { mapActions, mapState } from 'vuex';
export default {
  name: 'TurnFormComponent',
  data: () => ({
    menu: false,
  }),
  async mounted() {
    if (this.mode === 'update') {
      await this.getTurn(this.itemId);
    }
  },
  methods: {
    save() {
      const payload = {
        mode: this.mode,
        data: {
          status: this.item.status,
          id: this.item.id,
          turn: moment(this.item.turn, 'HH:mm').format('HH:mm'),
        },
      };
      try {
        this.saveTurn(payload);
      } catch (error) {
        console.log(error);
      }
    },
    ...mapActions(['getTurn', 'saveTurn']),
  },
  computed: {
    itemId() {
      return this.$route.query.id;
    },
    title() {
      return this.itemId ? 'Editar' : 'Agregar';
    },
    mode() {
      return this.itemId ? 'update' : 'create';
    },
    ...mapState({
      item: (state) => state.turnsModule.turn,
    }),
    turnErrors() {
      const errors = [];
      if (!this.$v.item.turn.$dirty) return errors;
      !this.$v.item.turn.required && errors.push('Turno es requerido');
      return errors;
    },
  },
};
</script>
