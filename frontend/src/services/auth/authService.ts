import api from "../../api/api";

const authService = {
  async login(payload: { email: string; password: string }) {
    const response = await api.post("/login/", payload);
    return response;
  },

  async logout() {
    const response = await api.post("/logout/");
    return response;
  },

  async registrar(payload: RegistroPayload) {
    const response = await api.post("/registrar/", payload);
    return response;
  },

  async me() {
    const response = await api.get("/me/");
    return response;
  },
};

export default authService;

type RegistroPayload = {
  usuario: string;
  email: string;
  password: string;
  password_confirmation: string;
};
