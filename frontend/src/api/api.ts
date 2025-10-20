import router from "@/router";
import axios from "axios";

const api = axios.create({
  baseURL: "http://localhost:8000/api",
  timeout: 10000,
  headers: { "Content-Type": "application/json" },
});

api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("token");
    if (token) {
      config.headers["Authorization"] = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

api.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    if (error.response && error.response.status === 401) {
      limparLocalStorage();
      router.push("/login");
    }
    return Promise.reject(error);
  }
);

function limparLocalStorage() {
  localStorage.removeItem("token");
  localStorage.removeItem("nome_usuario");
  localStorage.removeItem("email_usuario");
}
export default api;
