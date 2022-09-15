<template>
  <v-card>
    <v-card-title> {{ title }} Pelicula </v-card-title>
    <v-card-text>
      <v-container>
        <v-row>
          <v-col>
            <v-text-field
              label="Nombre"
              v-model="item.name"
              :error-messages="nameErrors"
              @input="$v.item.name.$touch()"
              @blur="$v.item.name.$touch()"
              data-cy="nameInput"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
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
                  v-model="item.published_at"
                  label="F. Publicacion"
                  prepend-icon="mdi-clock-time-four-outline"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                ></v-text-field>
              </template>
              <v-date-picker v-model="item.published_at" @input="menu = false">
              </v-date-picker>
            </v-menu>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-file-input
              v-model="image"
              accept="image/*"
              label="Imagen"
            ></v-file-input>
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
import { validationMixin } from 'vuelidate';
import { required } from 'vuelidate/lib/validators';
import moment from 'moment';
import { mapActions, mapState } from 'vuex';
export default {
  name: 'MovieFormComponent',
  mixins: [validationMixin],
  data: () => ({
    menu: false,
    image: [],
  }),
  validations: {
    item: {
      name: {
        required,
      },
    },
  },
  async mounted() {
    if (this.mode === 'update') {
      await this.getMovie(this.itemId);
    }
  },
  methods: {
    async save() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        let formData = new FormData();
        if (this.mode === 'update') {
          formData.append('_method', 'PUT');
        }
        if (this.image.name) {
          formData.append('image', this.image);
        }
        formData.append('name', this.item.name);
        formData.append('status', this.item.status);
        formData.append(
          'published_at',
          moment(this.item.published_at, 'YYYY-MM-DD').format('YYYY-MM-DD')
        );

        const payload = {
          mode: this.mode,
          data: formData,
          id: this.item.id,
        };

        try {
          await this.saveMovie(payload);
        } catch (error) {
          console.log(error);
        }
      }
    },
    ...mapActions(['getMovie', 'saveMovie']),
  },
  computed: {
    itemId() {
      return this.$route.query.id;
    },
    title() {
      return this.itemId ? 'Editar' : 'Agregar ';
    },
    mode() {
      return this.itemId ? 'update' : 'create';
    },
    ...mapState({
      item: (state) => state.moviesModule.movie,
    }),
    nameErrors() {
      const errors = [];
      if (!this.$v.item.name.$dirty) return errors;
      !this.$v.item.name.required && errors.push('El nombre es requerido');
      return errors;
    },
  },
};
</script>
