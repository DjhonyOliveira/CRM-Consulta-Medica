function botoesCrud() {
    let buttonsCrud = document.querySelectorAll('.btn-crud');
    let checkboxes  = document.querySelectorAll('.table-checkbox');
    let linhas      = document.querySelectorAll('tr[data-row-selectable]');

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                checkboxes.forEach(other => {
                    if (other !== checkbox) other.checked = false;
                });
            }
        });
    });

    linhas.forEach((linha) => {
        linha.addEventListener('click', (ev) => {
            if(ev.target.type === 'checkbox'){
                return;
            }

            const checkbox = linha.querySelector('.table-checkbox');

            if(!checkbox){
                return;
            }

            checkbox.checked = !checkbox.checked;

            if(checkbox.checked){
                checkboxes.forEach((outras) => {
                    if(outras !== checkbox){
                        outras.checked = false;
                    }
                })
            }
        });
    });

    buttonsCrud.forEach((button) => {
        button.addEventListener('click', () => {
            let acao = parseInt(button.getAttribute('data-acao'));
            let checkbox = document.querySelectorAll('.table-checkbox:checked') ?? [];
            let selecionados = Array.from(checkbox).map(check => check.value);

            if (acao !== ACAO_ADICIONAR && selecionados.length === 0) {
                alert('Selecione pelo menos uma opção na tela');

                return;
            }

            Livewire.dispatch('openModalFromJson', [{
                acao: acao,
                id: selecionados
            }]);
        });
    });

    document.querySelectorAll('form input').forEach((input) => {
        if (input.offsetParent === null) {
            input.removeAttribute('required');
        }
    });
}

export default botoesCrud;
