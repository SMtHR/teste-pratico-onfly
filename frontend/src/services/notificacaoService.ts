import api from "../api/api";

const url = "/notificacoes/";

const notificacaoService = {
  async buscarNotificacoes() {
    const response = await api.get(url);
    return response;
  },

  async marcarComoLida(uuidNotificacao: string) {
    const response = await api.post(`${url}${uuidNotificacao}/lida`);
    return response;
  },

  async marcarTodasComoLidas() {
    const response = await api.post(`${url}lidas/`);
    return response;
  },
};

export default notificacaoService;
