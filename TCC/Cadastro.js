const passwordIcons = document.querySelectorAll('.password-icon'); 

passwordIcons.forEach(icon => {
    icon.addEventListener('click',function(){
        const input= this.parentElement.querySelector('.form-control'); 
        input.type=input.type==='password'?'text':'password';
        this.classList.toggle('fa-eye');
    })
})

document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("last_name");
    const atletaRadio = document.getElementById("female");
    const clubeRadio = document.getElementById("male");

    let isCNPJ = false;

    function applyMask(value, type) {
        value = value.replace(/\D/g, '');

        if (type === "CPF") {
            value = value.slice(0, 11);
            value = value.replace(/(\d{3})(\d)/, "$1.$2");
            value = value.replace(/(\d{3})(\d)/, "$1.$2");
            value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        } else {
            value = value.slice(0, 14);
            value = value.replace(/^(\d{2})(\d)/, "$1.$2");
            value = value.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
            value = value.replace(/\.(\d{3})(\d)/, ".$1/$2");
            value = value.replace(/(\d{4})(\d{0,2})$/, "$1-$2");
        }

        return value;
    }

    input.addEventListener("input", function () {
        input.value = applyMask(input.value, isCNPJ ? "CNPJ" : "CPF");
    });

    atletaRadio.addEventListener("change", function () {
        if (this.checked) isCNPJ = false;
        input.value = applyMask(input.value, "CPF");
    });

    clubeRadio.addEventListener("change", function () {
        if (this.checked) isCNPJ = true;
        input.value = applyMask(input.value, "CNPJ");
    });
});


  const tipoInputs = document.querySelectorAll('input[name="gender"]');
  const labelCpfCnpj = document.querySelector('label[for="last_name"]');
  const inputCpfCnpj = document.getElementById("last_name");

  // Função para atualizar rótulo e placeholder
  function atualizarDocumento(tipo) {
    if (tipo === "female") {
      labelCpfCnpj.textContent = "CPF";
      inputCpfCnpj.placeholder = "999.999.999-99";
    } else {
      labelCpfCnpj.textContent = "CNPJ";
      inputCpfCnpj.placeholder = "XX.XXX.XXX/0001-XX";
    }
  }

  // Ao carregar a página, configura com base no valor inicial
  window.addEventListener("DOMContentLoaded", () => {
    const tipoSelecionado = document.querySelector('input[name="gender"]:checked').value;
    atualizarDocumento(tipoSelecionado);
  });

  // Ao trocar de opção, atualiza dinamicamente
  tipoInputs.forEach((input) => {
    input.addEventListener("change", function () {
      atualizarDocumento(this.value);
    });
  });



/*document.addEventListener("DOMContentLoaded", function () {
    const cpfInput = document.getElementById("last_name");

    cpfInput.addEventListener("input", function () {
        let value = cpfInput.value.replace(/\D/g, ''); // remove tudo que não é número

        if (value.length > 11) value = value.slice(0, 11); // limita a 11 dígitos

        // aplica a máscara CPF: 000.000.000-00
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");

        cpfInput.value = value;
    });
});*/ 