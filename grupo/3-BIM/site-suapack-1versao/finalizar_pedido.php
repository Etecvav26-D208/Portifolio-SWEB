<?php

session_start();

include("conexao.php");


/* Verificar carrinho */

if (
    !isset($_SESSION["carrinho"]) ||
    empty($_SESSION["carrinho"])
) {

    header("Location: carrinho.php");

    exit;
}


/* Verificar formulário */

if (
    !isset($_POST["nome_cliente"]) ||
    !isset($_POST["endereco"]) ||
    !isset($_POST["cep"]) ||
    !isset($_POST["forma_pagamento"])
) {

    header("Location: checkout.php");

    exit;
}


$nome_cliente = mysqli_real_escape_string(
    $conexao,
    $_POST["nome_cliente"]
);

$endereco = mysqli_real_escape_string(
    $conexao,
    $_POST["endereco"]
);

$cep = mysqli_real_escape_string(
    $conexao,
    $_POST["cep"]
);

$complemento = "";

if (isset($_POST["complemento"])) {

    $complemento = mysqli_real_escape_string(
        $conexao,
        $_POST["complemento"]
    );
}

$forma_pagamento = mysqli_real_escape_string(
    $conexao,
    $_POST["forma_pagamento"]
);


/* Montar endereço completo */

$endereco_completo =
    $endereco .
    " | CEP: " .
    $cep;

if (!empty($complemento)) {

    $endereco_completo .=
        " | Complemento: " .
        $complemento;
}


/* Calcular total */

$total = 0;

$itens = [];


foreach ($_SESSION["carrinho"] as $id_produto => $quantidade) {

    $id_produto = intval($id_produto);
    $quantidade = intval($quantidade);


    $sql = "
        SELECT *
        FROM produtos
        WHERE id_produto = $id_produto
    ";

    $resultado = mysqli_query(
        $conexao,
        $sql
    );


    if (
        !$resultado ||
        mysqli_num_rows($resultado) == 0
    ) {

        continue;
    }


    $produto = mysqli_fetch_assoc(
        $resultado
    );


    /* Verificar estoque */

    if ($quantidade > $produto["estoque"]) {

        $quantidade = $produto["estoque"];
    }


    if ($quantidade <= 0) {

        continue;
    }


    /* Definir preço */

    if (
        $produto["em_promocao"] == 1 &&
        !empty($produto["preco_promocional"]) &&
        $produto["preco_promocional"] > 0
    ) {

        $preco = $produto["preco_promocional"];

    } else {

        $preco = $produto["preco"];
    }


    $subtotal =
        $preco * $quantidade;


    $total += $subtotal;


    $itens[] = [

        "id_produto" => $id_produto,

        "quantidade" => $quantidade,

        "preco" => $preco

    ];
}


/* Verificar se existe algum item */

if (empty($itens)) {

    header("Location: carrinho.php");

    exit;
}


/* Criar pedido */

$total_banco = number_format(
    $total,
    2,
    ".",
    ""
);


$sql_pedido = "
    INSERT INTO pedidos
    (
        nome_cliente,
        endereco,
        forma_pagamento,
        valor_total,
        status_pedido
    )
    VALUES
    (
        '$nome_cliente',
        '$endereco_completo',
        '$forma_pagamento',
        '$total_banco',
        'Pendente'
    )
";


if (!mysqli_query($conexao, $sql_pedido)) {

    die("Erro ao criar o pedido.");
}


/* Pegar ID do pedido */

$id_pedido = mysqli_insert_id(
    $conexao
);


/* Salvar os itens */

foreach ($itens as $item) {

    $id_produto =
        $item["id_produto"];

    $quantidade =
        $item["quantidade"];

    $preco =
        number_format(
            $item["preco"],
            2,
            ".",
            ""
        );


    $sql_item = "
        INSERT INTO itens_pedido
        (
            id_pedido,
            id_produto,
            quantidade,
            preco_unitario
        )
        VALUES
        (
            '$id_pedido',
            '$id_produto',
            '$quantidade',
            '$preco'
        )
    ";


    mysqli_query(
        $conexao,
        $sql_item
    );


    /* Diminuir estoque */

    $sql_estoque = "
        UPDATE produtos
        SET estoque = estoque - $quantidade
        WHERE id_produto = $id_produto
    ";

    mysqli_query(
        $conexao,
        $sql_estoque
    );
}


/* Limpar carrinho */

unset(
    $_SESSION["carrinho"]
);


/* Ir para confirmação */

header(
    "Location: pedido_confirmado.php?id=" .
    $id_pedido
);

exit;

?>
