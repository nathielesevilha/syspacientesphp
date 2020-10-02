var getUrlParameter = function getUrlParameter(sParam) {
  var sPageURL = window.location.search.substring(1),
    sURLVariables = sPageURL.split("&"),
    sParameterName,
    i;

  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split("=");

    if (sParameterName[0] === sParam) {
      return sParameterName[1] === undefined
        ? true
        : decodeURIComponent(sParameterName[1]);
    }
  }
};

function mascaras() {
  $("#inputCelular").inputmask("(99) 99999-9999");
  $("#inputDataNascimento").inputmask("99/99/9999");
  $("#inputTelefone").inputmask("(99) 9999-9999");
  $("#inputCep").inputmask("99.999-999");
}

function validateEmail(email) {
  const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

function validateDate(dateString) {
  var parts = dateString.split("/");
  var day = parseInt(parts[0], 10);
  var month = parseInt(parts[1], 10);
  var year = parseInt(parts[2], 10);

  if (year < 1000 || year > 3000 || month == 0 || month > 12) {
    return false;
  }
  var monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

  if (year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
    monthLength[1] = 29;

  return day > 0 && day <= monthLength[month - 1];
}

(function ($) {
  $.fn.inputFilter = function (inputFilter) {
    return this.on(
      "input keydown keyup mousedown mouseup select contextmenu drop",
      function () {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          this.value = "";
        }
      }
    );
  };
})(jQuery);

var Campos = [
  {
    nome: "nome",
    valido: false,
  },
  {
    nome: "email",
    valido: false,
  },
  {
    nome: "dataNascimento",
    valido: false,
  },
  {
    nome: "telefone",
    valido: true,
  },
  {
    nome: "celular",
    valido: false,
  },
  {
    nome: "cep",
    valido: false,
  },
  {
    nome: "endereco",
    valido: false,
  },
  {
    nome: "numero",
    valido: false,
  },
  {
    nome: "complemento",
    valido: true,
  },
  {
    nome: "cidade",
    valido: false,
  },
];

function mudaStatusCampos(nome, valido) {
  Campos.forEach((item) => {
    if (item.nome == nome) {
      item.valido = valido;
    }
  });

  validaBotaoSalvar();
}

function validaBotaoSalvar() {
  let valido = true;

  Campos.forEach((item) => {
    if (!item.valido) {
      valido = false;
    }
  });

  $("#btnSalvar").prop("disabled", !valido);
}

$(document).ready(function () {
  mascaras();
  $(".apenas-numeros").inputFilter((value) => {
    return /^\d*$/.test(value);
  });

  var pessoa = getUrlParameter("idPessoa");

  validaBotaoSalvar();

  if (pessoa != undefined) {
    $("#inputNome").trigger("change");
    $("#inputEmail").trigger("change");
    $("#inputDataNascimento").trigger("change");
    $("#inputTelefone").trigger("change");
    $("#inputCelular").trigger("change");
    $("#inputCep").trigger("change");
    $("#inputEndereco").trigger("change");
    $("#inputNumero").trigger("change");
    $("#inputComplemento").trigger("change");
    $("#inputCidade").trigger("change");
  }
});

$("#inputEmail").on("change focusout", function (e) {
  var email = $(this).val();
  if (!validateEmail(email)) {
    $(this).addClass("is-invalid");
    mudaStatusCampos("email", false);
  } else {
    $(this).addClass("is-valid");
    mudaStatusCampos("email", true);
  }
});

$("#inputNome").on("change focusout", function (e) {
  var nome = $(this).val();
  if (nome.length < 3 || nome.length > 100) {
    mudaStatusCampos("nome", false);
    $(this).addClass("is-invalid");
  } else {
    mudaStatusCampos("nome", true);
    $(this).addClass("is-valid");
  }
});

$("#inputDataNascimento").on("change focusout", function (e) {
  var data = $(this).val();
  data = data.replace(/_/g, "");
  if (data.length < 10 || !validateDate(data)) {
    $(this).addClass("is-invalid");
    mudaStatusCampos("dataNascimento", false);
  } else {
    $(this).addClass("is-valid");
    mudaStatusCampos("dataNascimento", true);
  }
});

$("#inputTelefone").on("change focusout", function (e) {
  var data = $(this).val();
  data = data.replace(/_/g, "");
  if (data.length == 0) {
    $(this).removeClass("is-invalid");
    $(this).removeClass("is-valid");
    mudaStatusCampos("telefone", true);
  } else if (data.length < 14) {
    $(this).addClass("is-invalid");
    mudaStatusCampos("telefone", false);
  } else {
    $(this).addClass("is-valid");
    mudaStatusCampos("telefone", true);
  }
});

$("#inputCelular").on("change focusout", function (e) {
  var data = $(this).val();
  data = data.replace(/_/g, "");
  if (data.length < 15) {
    $(this).addClass("is-invalid");
    mudaStatusCampos("celular", false);
  } else {
    $(this).addClass("is-valid");
    mudaStatusCampos("celular", true);
  }
});

$("#inputCep").on("change focusout", function (e) {
  var cep = $(this).val();
  cep = cep.replace(/_/g, "");
  if (cep.length < 10) {
    $(this).addClass("is-invalid");
    mudaStatusCampos("cep", false);
  } else {
    $(this).addClass("is-valid");
    mudaStatusCampos("cep", true);
  }
});

$("#inputEndereco").on("change focusout", function (e) {
  var endereco = $(this).val();
  if (endereco.length > 3 || endereco.length < 100) {
    $(this).addClass("is-valid");
    mudaStatusCampos("endereco", true);
  } else {
    $(this).addClass("is-invalid");
    mudaStatusCampos("endereco", false);
  }
});

$("#inputNumero").on("change focusout", function (e) {
  var numero = $(this).val();

  if (numero.length > 0) {
    numero = parseInt(numero);
    if (numero != undefined) {
      $(this).addClass("is-valid");
      mudaStatusCampos("numero", true);
    } else {
      $(this).addClass("is-invalid");
      mudaStatusCampos("numero", false);
    }
  }
});

$("#inputComplemento").on("change focusout", function (e) {
  var complemento = $(this).val();
  if (complemento.length == 0) {
    $(this).removeClass("is-invalid");
    $(this).removeClass("is-valid");
    mudaStatusCampos("complemento", true);
  } else if (complemento.length < 50) {
    $(this).addClass("is-valid");
    mudaStatusCampos("complemento", true);
  } else {
    $(this).addClass("is-invalid");
    mudaStatusCampos("complemento", false);
  }
});

$("#inputCidade").on("change focusout", function (e) {
  var cidade = $(this).val();
  if (cidade.length > 0 && cidade.length < 100) {
    $(this).addClass("is-valid");
    mudaStatusCampos("cidade", true);
  } else {
    $(this).addClass("is-invalid");
    mudaStatusCampos("complemento", false);
  }
});

$("input").on("focusin", function (e) {
  $(this).removeClass("is-invalid");
  $(this).removeClass("is-valid");
});
