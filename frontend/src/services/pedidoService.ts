import api from "../api/api";

const url = "/pedidos/";

const pedidoService = {
  async buscarPedidos() {
    const response = await api.get(url);
    return response;
  },

  async criarPedido(payload: CriarPedidoPayload) {
    const response = await api.post(url, payload);
    return response;
  },

  async aprovarPedido(idPedido: number) {
    const response = await api.post(`${url}${idPedido}/aprovar/`);
    return response;
  },

  async cancelarPedido(idPedido: number) {
    const response = await api.post(`${url}${idPedido}/cancelar/`);
    return response;
  },
};

export default pedidoService;

type CriarPedidoPayload = {
  nome_cliente: string;
  destino: string;
  dt_ida: string;
  dt_volta: string;
};
