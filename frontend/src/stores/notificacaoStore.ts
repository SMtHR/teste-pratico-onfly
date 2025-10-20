// Utilities
import router from "@/router";
import authService from "@/services/auth/authService";
import notificacaoService from "@/services/notificacaoService";
import { defineStore } from "pinia";

type Notificacao = {
  id: string;
  type: string;
  notifiable_type: string;
  notifiable_id: string;
  data: {
    pedido_id: number;
    mensagem: string;
    nome_cliente: string;
    status: string;
    data: string;
  };
  read_at: string;
  created_at: Date;
  updated_at: Date;
};

export const useNotificacaoStore = defineStore("notificacaoStore", () => {
  const notificacoes = ref<Notificacao[]>([]);

  const snackbar = reactive({
    show: false as boolean,
    text: "" as string,
    messages: [] as string[],
    color: "" as string,
  });

  async function buscarNotificacoes() {
    try {
      const { data } = await notificacaoService.buscarNotificacoes();
      notificacoes.value = data;
    } catch (e: any) {
      console.log(e);
    }
  }

  async function marcarComoLida(uuidNotificacao: string) {
    try {
      const { data } = await notificacaoService.marcarComoLida(uuidNotificacao);
      showSnackbar(data.message, "success");
      buscarNotificacoes();
    } catch (e: any) {
      console.log(e);
    }
  }

  async function marcarTodasComoLidas() {
    try {
      const { data } = await notificacaoService.marcarTodasComoLidas();
      showSnackbar(data.message, "success");
      buscarNotificacoes();
    } catch (e: any) {
      console.log(e);
    }
  }

  function showSnackbar(text: string, color: string) {
    snackbar.show = true;
    snackbar.messages.push(text);
    snackbar.color = color;
  }

  function resetDadosNotificacoes() {
    notificacoes.value = [];
  }

  return {
    notificacoes,
    snackbar,
    buscarNotificacoes,
    marcarComoLida,
    marcarTodasComoLidas,
    showSnackbar,
    resetDadosNotificacoes,
  };
});
