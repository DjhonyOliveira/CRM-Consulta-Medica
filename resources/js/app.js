import './bootstrap';
import './globals.js';
import './alertHandler.js';

import ExternoMedicos   from './components/ExternoMedicos.js';
import ExternoPacientes from './components/ExternoPacientes.js';
import modal            from './components/modal.js';
import submitModal      from './submitModal.js';
import botoesCrud       from './components/botoesCrud.js';

const selecionarMedico   = new ExternoMedicos();
const selecionarPaciente = new ExternoPacientes();

window.Modal       = modal;
window.submitModal = submitModal;
window.buttonCrud  = botoesCrud;

window.selecionarMedico = (linha) => {
    selecionarMedico.selecionar(linha);
};

window.selecionarPaciente = (linha) => {
    selecionarPaciente.selecionar(linha);
}

window.abrirModalExternoMedico = () => {
    selecionarMedico.abrirModalExternoMedico();
}

window.abrirModalExternoPaciente = () => {
    selecionarPaciente.abrirModalExternoPaciente();
}

window.especialidadeSelecionada = () => {
    selecionarMedico.especialidadeSelecionada();
}