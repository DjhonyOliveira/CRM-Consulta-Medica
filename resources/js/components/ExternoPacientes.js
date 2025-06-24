export default class ExternoPacientes{

   constructor(config = {}) {
        this.inputId             = config.inputId             || 'paciente_id';
        this.inputNome           = config.inputNome           || 'paciente_nome';
        this.endpoint            = config.endpoint            || '/pacientes';
    }

    abrirModalExternoPaciente = () => {
        window.dispatchEvent(new CustomEvent('abrir-modal-externo-paciente'));
    }
    
    selecionar = (rowElement) => {
        let pacienteId   = rowElement.dataset.id;
        let pacienteNome = rowElement.dataset.nome;

        if(!pacienteId && !pacienteNome){
            return;
        }

        this.preencheCampos(pacienteId, pacienteNome);

        window.dispatchEvent(new CustomEvent('fechar-modal-externo-paciente'));
    }

    preencheCampos = (id, nome) => {
        let inputId   = document.getElementById(this.inputId);
        let inputNome = document.getElementById(this.inputNome);

        if(inputId){
            inputId.value = id;
        }

        if(inputNome){
            inputNome.value = nome;
        }
    }

}