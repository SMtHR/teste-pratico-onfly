// Utilities
import { defineStore } from "pinia";
import pedidoService from "@/services/pedidoService";
import { useNotificacaoStore } from "./notificacaoStore";
import { useAuthStore } from "./authStore";

export const usePedidoStore = defineStore("pedidoStore", () => {
  const notificacaoStore = useNotificacaoStore();
  const authStore = useAuthStore();

  const isCriarPedidoOpen = ref(false);
  const isAprovarPedidoOpen = ref(false);
  const isCancelarPedidoOpen = ref(false);
  const campoPesquisa = ref("");
  const loading = ref(false);
  const criarPedidoForm = reactive({
    nome_cliente: "" as string,
    destino: "" as string,
    dt_ida: "" as string,
    dt_volta: "" as string,
  });
  const pedidos = ref<any>([]);
  const pedidoSelecionado = ref<any>();

  async function buscarPedidos() {
    loading.value = true;
    try {
      const { data } = await pedidoService.buscarPedidos();
      pedidos.value = data;
    } catch (e: any) {
      notificacaoStore.showSnackbar("Erro ao buscar pedidos", "error");
    } finally {
      loading.value = false;
    }
  }

  async function criarPedido() {
    try {
      const { data } = await pedidoService.criarPedido(criarPedidoForm);
      notificacaoStore.showSnackbar(data.message, "success");
      buscarPedidos();
    } catch (e: any) {
      notificacaoStore.showSnackbar(e.response.data.message, "error");
      console.error(e);
    } finally {
      isCriarPedidoOpen.value = false;
      limparFormulario();
    }
  }

  async function aprovarPedido() {
    try {
      const { data } = await pedidoService.aprovarPedido(
        pedidoSelecionado.value.id
      );
      notificacaoStore.showSnackbar(data.message, "success");
      buscarPedidos();
    } catch (e: any) {
      notificacaoStore.showSnackbar(e.response.data.message, "error");
      console.error(e);
    } finally {
      isAprovarPedidoOpen.value = false;
      pedidoSelecionado.value = undefined;
      notificacaoStore.buscarNotificacoes();
    }
  }

  async function cancelarPedido() {
    try {
      const { data } = await await pedidoService.cancelarPedido(
        pedidoSelecionado.value.id
      );
      notificacaoStore.showSnackbar(data.message, "success");
      buscarPedidos();
    } catch (e: any) {
      notificacaoStore.showSnackbar(e.response.data.message, "error");
      console.error(e);
    } finally {
      isCancelarPedidoOpen.value = false;
      pedidoSelecionado.value = undefined;
      notificacaoStore.buscarNotificacoes();
    }
  }

  function limparFormulario() {
    criarPedidoForm.nome_cliente = "";
    criarPedidoForm.destino = "";
    criarPedidoForm.dt_ida = "";
    criarPedidoForm.dt_volta = "";
  }

  function resetDadosPedidos() {
    pedidos.value = [];
  }

  return {
    isCriarPedidoOpen,
    isAprovarPedidoOpen,
    isCancelarPedidoOpen,
    loading,
    campoPesquisa,
    criarPedidoForm,
    pedidos,
    pedidoSelecionado,
    buscarPedidos,
    criarPedido,
    aprovarPedido,
    cancelarPedido,
    resetDadosPedidos,
  };
});
