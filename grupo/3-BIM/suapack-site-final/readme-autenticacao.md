# SUA PACK - Autenticação

## Banco novo
Importe `banco/suapack.sql`.

## Banco que já existe
Importe `banco/atualizar_autenticacao.sql` para preservar os dados.

## Admin inicial
E-mail: `mariaeduardaporodrigues@gmail.com`
Senha: `246587#`

Troque a senha depois do primeiro acesso.

## Cliente
Use `cadastro.php` para criar uma conta. A senha é armazenada com `password_hash()` e conferida com `password_verify()`.

## Fluxo
Cliente -> login -> carrinho -> checkout -> pedido vinculado ao usuário.
Admin -> login -> painel -> CRUDs protegidos.


## Acesso administrativo
A conta principal administrativa é mariaeduardaporodrigues@gmail.com. Pelo perfil dessa conta é possível criar outras contas de administrador.
