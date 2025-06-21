import './bootstrap';
import './globals.js';
import './alertHandler.js';

import ExternoMedicos from './components/ExternoMedicos.js';
import modal          from './components/modal.js';
import submitModal    from './submitModal.js';
import botoesCrud     from './components/botoesCrud.js';

const selecionarMedico = new ExternoMedicos();

window.Modal       = modal;
window.submitModal = submitModal;
window.buttonCrud  = botoesCrud;

window.selecionarMedico = (linha) => {
    selecionarMedico.selecionar(linha);
};

window.abrirModalExterno = () => {
    selecionarMedico.abrirModalExternoMedico();
}

window.especialidadeSelecionada = () => {
    selecionarMedico.especialidadeSelecionada();
}