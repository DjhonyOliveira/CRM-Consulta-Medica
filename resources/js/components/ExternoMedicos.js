export default class ExternoMedicos{

    constructor(config = {}) {
        this.inputId             = config.inputId             || 'medico_id';
        this.inputNome           = config.inputNome           || 'medico_nome';
        this.selectEspecialidade = config.selectEspecialidade || 'especialidade_id';
        this.endpoint            = config.endpoint            || '/medicos';
    }

    abrirModalExternoMedico = () =>{
        window.dispatchEvent(new CustomEvent('abrir-modal-externo-medico'));
    }

    selecionar = (rowElement) => {
        let medicoId   = rowElement.dataset.id;
        let medicoNome = rowElement.dataset.nome;

        if(!medicoId && !medicoNome){
            return;
        }

        this.preencherCampos(medicoId, medicoNome);

        window.dispatchEvent(new CustomEvent('fechar-modal-externo-medico'));

        this.buscarEspecialidades(medicoId);
    }

    preencherCampos = (id, nome) => {
        let inputId   = document.getElementById(this.inputId);
        let inputNome = document.getElementById(this.inputNome);       
        
        if(inputId){
            inputId.value = id;
        }

        if(inputNome){
            inputNome.value = nome;
        }
    }

    buscarEspecialidades = (medicoId) => {
        const select     = document.getElementById(this.selectEspecialidade);

        if(!select){
            return;
        }

        select.innerHTML = '<option value="">Carregando...</option>';

        fetch(`${this.endpoint}/${medicoId}/especialidades`)
            .then(res => {
                if(!res.ok){
                    throw new Error('Erro na requisição');
                }

                return res.json();
            })
            .then(data => {
                this.preencherEspecialidades(select, data);
            })
            .catch(err => {
                console.error('Erro ao buscar especialidades:', err);

                select.innerHTML = '<option value="">Erro ao carregar</option>';
            });
    }

    preencherEspecialidades = (select, especialidades) => {
        select.innerHTML = '<option value="" selected disabled>Selecione...</option>';

        if (!especialidades || especialidades.length === 0) {
            select.innerHTML = '<option value="">Nenhuma especialidade encontrada</option>';

            return;
        }

        for(const esp of especialidades) {
            const option = document.createElement('option');

            option.value       = esp.id;
            option.textContent = esp.nome;

            select.appendChild(option);
        }
    }

    especialidadeSelecionada = () => {
        let idMedico         = document.getElementById('medico_id')?.value;
        let especialidade_id = document.getElementById('especialidade_id')?.value;

        if(!idMedico && !especialidade_id){
            return;
        }

        this.buscarValorConsulta(idMedico, especialidade_id);
        this.buscarhorarios(idMedico, especialidade_id);
    }

    buscarhorarios = (medicoId, especialidadeId) => {
        let select = document.querySelector('select[name="horario_id"]');

        if(!select){
            return
        }

        select.innerHTML = '<option value="">Carregando...</option>';

        fetch(`/consulta/horarios-disponiveis/${medicoId}/${especialidadeId}`)
            .then(response => response.json())
            .then(data => {
                select.innerHTML = '<option value="" selected disabled>Selecione...</option>';

                if(!data.length){
                    select.innerHTML = '<option value="">Nunhum horário disponivel...</option>';

                    return;
                }

                for(let horario of data){
                    let option = document.createElement('option');

                    option.value       = horario.id;
                    option.textContent = horario.dateTime;

                    select.appendChild(option);
                }
            })
            .catch(error => {
                showBladeToast('Falha ao retornar os horários para consulta', 'error');
            });
    }

    buscarValorConsulta = (medicoId, especialidadeId) => {
        let inputValor = document.getElementById('valor');

        if (!inputValor){
            return;
        }

        fetch(`/consulta/valor-consulta/${medicoId}/${especialidadeId}`)
            .then(res => res.json())
            .then(data => {
                inputValor.value = data.valor?.toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL',
                }) || 'R$ 0,00';
            })
            .catch((error) => {
                showBladeToast('Falha ao retornar o valor da consulta', 'error');
            });
    }
}