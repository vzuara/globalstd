<template>
  <v-card min-width="525px" class="p-3">
    <v-card-title class="justify-center">
      <v-img
        alt="GlobalSTD logo"
        class="logo shrink"
        contain
        src="./../../assets/logo.png"
        transition="scale-transition"
        width="150"
      />
    </v-card-title>
    <v-card-text>
      <v-text-field
        label="Usuario"
        v-model="email"
        :error-messages="emailErrors"
        @input="$v.email.$touch()"
        @blur="$v.email.$touch()"
      />
      <v-text-field
        label="Contraseña"
        type="password"
        v-model="password"
        :error-messages="passwordErrors"
        @input="$v.password.$touch()"
        @blur="$v.password.$touch()"
      />
    </v-card-text>
    <v-card-actions>
      <v-btn
        elevation="0"
        @click="login"
        dark
        outlined
        rounded
        small
        color="primary"
      >
        Login
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { validationMixin } from 'vuelidate';
import { required, email, minLength } from 'vuelidate/lib/validators';
import { mapActions } from 'vuex';
export default {
  name: 'LoginComponent',
  mixins: [validationMixin],
  data: () => ({
    email: 'test@example.com',
    password: 'password',
  }),
  validations: {
    email: {
      required,
      email,
    },
    password: {
      required,
      minLength: minLength(4),
    },
  },
  methods: {
    ...mapActions(['sendLogin']),
    async login() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        const response = await this.sendLogin({
          email: this.email,
          password: this.password,
        });
        if (response) {
          this.$router.push('/admin');
        }
      }
    },
  },
  computed: {
    emailErrors() {
      const errors = [];
      if (!this.$v.email.$dirty) return errors;
      !this.$v.email.email && errors.push('El correo debe ser valido');
      !this.$v.email.required && errors.push('E-mail es requerido');
      return errors;
    },
    passwordErrors() {
      const errors = [];
      if (!this.$v.password.$dirty) return errors;
      !this.$v.password.required && errors.push('La contraseña es requerida');
      !this.$v.password.minLength &&
        errors.push('La contraseña deber de al menos 4 caracteres');
      return errors;
    },
  },
};
</script>
