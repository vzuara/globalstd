import { mapActions } from 'vuex';
<template>
  <v-card>
    <v-card-title> Asignación de horario</v-card-title>
    <v-card-text>
      <v-container>
        <v-row>
          <v-col>
            <h1>Película: {{ movie.name }}</h1>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-sheet outlined rounded>
              <v-tabs
                v-model="tab"
                rounded
                centered
                icons-and-text
                align-with-title
              >
                <v-tabs-slider></v-tabs-slider>

                <v-tab href="#assignments" class="">
                  <h4>Turnos Asignados</h4>
                </v-tab>
                <v-tab href="#noAssignments">
                  <h4>Turnos por asignar</h4>
                </v-tab>
              </v-tabs>
              <v-divider></v-divider>

              <v-tabs-items v-model="tab">
                <v-tab-item value="assignments">
                  <v-card class="elevation-1">
                    <AssignmentTable
                      :movieId="parseInt(movieId)"
                      :items="movie.turns"
                      v-if="movie.turns"
                      @refreshData="getData"
                    />
                  </v-card>
                </v-tab-item>
                <v-tab-item value="noAssignments">
                  <v-card flat>
                    <AssignmentForm
                      @refreshData="getData"
                      :movieId="parseInt(movieId)"
                    />
                  </v-card>
                </v-tab-item>
              </v-tabs-items>
            </v-sheet>
          </v-col>
        </v-row>
      </v-container>
    </v-card-text>
  </v-card>
</template>

<script>
import { mapState, mapActions, mapMutations } from 'vuex';
import AssignmentTable from './AssignmentTable.vue';
import AssignmentForm from './AssignmentForm.vue';

export default {
  name: 'AssignmentsComponent',
  components: {
    AssignmentTable,
    AssignmentForm,
  },
  data: () => ({
    tab: 'noAssignments',
  }),
  mounted() {
    if (!this.movieId) {
      this.$router.push({ name: 'Movies' });
    }
    this.getData();
  },
  methods: {
    ...mapActions(['getMovie', 'getTurns']),
    ...mapMutations(['setItemsPerPage']),
    getData() {
      this.getMovie(this.movieId);
      this.setItemsPerPage(null);
      this.getTurns();
    },
  },
  computed: {
    ...mapState({
      movie: (state) => state.moviesModule.movie,
    }),
    movieId() {
      return this.$route.query.id;
    },
  },
};
</script>
