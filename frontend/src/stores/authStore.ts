import router from "@/router";
import authService from "@/services/auth/authService";
import { defineStore } from "pinia";
import { usePedidoStore } from "./pedidoStore";
import { useNotificacaoStore } from "./notificacaoStore";

export const useAuthStore = defineStore("authStore", () => {
  const pedidoStore = usePedidoStore();
  const notificacaoStore = useNotificacaoStore();

  const registroForm = reactive({
    usuario: "" as string,
    email: "" as string,
    password: "" as string,
    password_confirmation: "" as string,
  });
  const loginForm = reactive({
    email: "" as string,
    password: "" as string,
  });
  const usuario = ref<any>([]);
  const token = ref<string | null>();

  const snackbar = reactive({
    show: false as boolean,
    message: "" as string,
    color: "" as string,
  });

  async function login() {
    try {
      const { data } = await authService.login(loginForm);
      usuario.value = data.usuario;
      setLocalStorage(
        data.access_token,
        data.usuario.usuario,
        data.usuario.email
      );
      router.push("/");
    } catch (e: any) {
      console.log(e);
      showSnackbar(e.response.data.message, "error");
    }
  }

  async function logout() {
    await authService.logout();
    usuario.value = undefined;
    limparLocalStorage();
    router.push("/login");
    setTimeout(() => {
      pedidoStore.resetDadosPedidos();
      notificacaoStore.resetDadosNotificacoes();
    }, 200);
  }

  async function registrar() {
    try {
      const { data } = await authService.registrar(registroForm);
      setLocalStorage(
        data.access_token,
        data.usuario.usuario,
        data.usuario.email
      );
      usuario.value = data.usuario;
      showSnackbar(data.message, "success");
      router.push("/");
    } catch (e: any) {
      showSnackbar(e.response.data.message, "error");
    }
  }

  async function fetchUsuario() {
    const token = localStorage.getItem("token");
    if (!token) return;

    try {
      const { data } = await authService.me();
      console.log(data);
      usuario.value = data;
    } catch (e: any) {
      showSnackbar(e.response.data.message, "error");
      console.error("Falha ao buscar usuário, token inválido.", e);
      logout();
    }
  }

  function showSnackbar(message: string, color: string) {
    snackbar.show = true;
    snackbar.message = message;
    snackbar.color = color;
  }

  function setLocalStorage(
    access_token: string,
    usuario: string,
    email: string
  ) {
    localStorage.setItem("token", access_token);
    localStorage.setItem("nome_usuario", usuario);
    localStorage.setItem("email_usuario", email);
  }

  function limparLocalStorage() {
    localStorage.removeItem("token");
    localStorage.removeItem("nome_usuario");
    localStorage.removeItem("email_usuario");
  }

  return {
    registroForm,
    loginForm,
    usuario,
    token,
    snackbar,
    login,
    logout,
    registrar,
    fetchUsuario,
    setLocalStorage,
    limparLocalStorage,
  };
});
