function submitModal(){
    document.getElementById('formModal').addEventListener('submit', async function(ev) {
        ev.preventDefault();

        const form   = ev.target;
        const data   = new FormData(form);

        const methodInput   = form.querySelector('input[name="_method"]');
        const spoofedMethod = methodInput ? methodInput.value.toUpperCase() : 'POST';

        if (['DELETE', 'PUT', 'PATCH'].includes(spoofedMethod)) {
            data.append('_method', spoofedMethod);
        }

        document.querySelectorAll('.error-message').forEach(elemento => elemento.textContent = '');

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept'      : 'application/json'
            },
            body: data
        })
        .then(async (response) => {
            const json = await response.json();

            if (!response.ok) {
                if (json.errors) {
                    for (let error in json.errors) {
                        const elemento = document.querySelector(`.error-message[data-field="${error}"]`);

                        if (elemento) {
                            elemento.textContent = json.errors[error].join(', ');
                        }
                    }
                }

                throw new Error(json.message || "Erro ao enviar o formulário");
            }

            return json;
        })
        .then((result) => {
            let type = result.type || 'success';
            let msg  = result.message || "Sucesso!";

            showBladeToast(msg, type);        

            Livewire.dispatch('dadosAtualizados');

            form.reset();

            setTimeout(()=>{
                Livewire.dispatch('atualizacaoRealizada');
            }, 1000);
        })
        .catch((error)=>{
            console.error(error);

            if(error.message && error.message.length < 300){
                showBladeToast(error.message, 'error');
            }
            else{
                showExceptionPopup(error.message);
            }
        });
    });
}

export default submitModal;