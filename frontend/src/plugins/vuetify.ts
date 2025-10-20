/**
 * plugins/vuetify.ts
 *
 * Framework documentation: https://vuetifyjs.com`
 */

// Styles
import "@mdi/font/css/materialdesignicons.css";
import "vuetify/styles";
import { pt } from "vuetify/locale";

// Composables
import { createVuetify } from "vuetify";
import { VDateInput } from "vuetify/labs/VDateInput";

// https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides
export default createVuetify({
  theme: {
    defaultTheme: "light",
  },
  components: {
    VDateInput,
  },
  locale: {
    locale: "pt",
    fallback: "en",
    messages: { pt },
  },
  date: {
    locale: {
      en: "pt",
    },
  },
});
