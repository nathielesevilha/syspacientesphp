<?php
session_start();
require_once('variaveis.php');
require_once('conexao.php');

$id                = $_POST["inputIdPessoa"];
$nome              = $_POST["inputNome"];
$email             = $_POST["inputEmail"];
$dataNascimento    = $_POST["inputDataNascimento"];
$telefone          = $_POST["inputTelefone"];
$celular           = $_POST["inputCelular"];
$cep               = $_POST["inputCep"];
$endereco          = $_POST["inputEndereco"];
$numero            = $_POST["inputNumero"];
$complemento       = $_POST["inputComplemento"];
$cidade            = $_POST["inputCidade"];
$estado            = $_POST["cmbEstados"];

$sql;

$nome = strtoupper($nome);

if (strlen($id) == 0 || $id == 0) {

    $sql = "   INSERT INTO pessoas
                (
                    nome, endereco, numero,
                    complemento, cidade, estado,
                    cep, datanascimento, telefone,
                    celular, email)
                VALUES
                (
                    '$nome', '$endereco', $numero,
                    '$complemento', '$cidade', '$estado',
                    '$cep', '$dataNascimento', '$telefone', 
                    '$celular', '$email'
                )";
} else {
    $sql = "UPDATE pessoas SET
    nome                = '$nome', 
    email               = '$email', 
    datanascimento      = '$dataNascimento', 
    telefone            = '$telefone',
    celular             = '$celular',
    cep                 = '$cep',
    endereco            = '$endereco',
    numero              =  $numero,
    complemento         = '$complemento',
    cidade              = '$cidade',
    estado              = '$estado'
    WHERE idPessoa = $id";
}
echo ($sql);

mysqli_query($conexao_bd, $sql);
mysqli_close($conexao_bd);
header("location:pessoa_list.php");
