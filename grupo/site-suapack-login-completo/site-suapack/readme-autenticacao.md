# SUA PACK - Autenticação

## Banco novo
Importe `banco/suapack.sql`.

## Banco que já existe
Importe `banco/atualizar_autenticacao.sql` para preservar os dados.

## Admin inicial
E-mail: `admin@suapack.com`
Senha: `Admin@123`

Troque a senha depois do primeiro acesso.

## Cliente
Use `cadastro.php` para criar uma conta. A senha é armazenada com `password_hash()` e conferida com `password_verify()`.

## Fluxo
Cliente -> login -> carrinho -> checkout -> pedido vinculado ao usuário.
Admin -> login -> painel -> CRUDs protegidos.
