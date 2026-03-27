## Instituição 
`ETEC Vasco Antônio Venchiarutti`

---

## Curso
`Informática para Internet`

---

## Turma
`2°D`

---

## Autores
- `Maria Eduarda Pinto de Oliveira Rodrigues `
- `Mariana Rasmussen Rezende Alves`
- `Natan`
- `Pietro Fiorese Dopp`


  
# Atividade sobre Cookies e Sessões  

## Exercício 1  
**Pergunta:** Explique a diferença entre cookies e sessões no PHP.  

Cookies e sessões são usados para armazenar dados do usuário no PHP, porém funcionam de formas diferentes.  
Os cookies ficam armazenados no navegador do usuário, o que os torna menos seguros, pois podem ser acessados ou modificados.  
Já as sessões armazenam os dados diretamente no servidor.  
No navegador, fica apenas um identificador único da sessão.  
Esse identificador é enviado a cada requisição.  
Assim, o servidor consegue recuperar os dados com segurança.  
Cookies são mais usados para dados simples e duradouros.  
Como preferências de idioma, tema e personalização.  
Sessões são indicadas para dados sensíveis.  
Como login, permissões e informações privadas.  


## Exercício 2  
**Pergunta:** Como cookies e sessões podem ser usados em uma loja virtual?  

Em uma loja virtual, as sessões são ideais para manter o usuário autenticado.  
Quando o usuário faz login, o servidor cria uma sessão com seus dados.  
O navegador armazena apenas o identificador dessa sessão.  
Isso aumenta a segurança durante a navegação.  
As sessões também são usadas no carrinho de compras.  
Pois os itens mudam com frequência e são temporários.  
Já os cookies são usados para preferências do usuário.  
Como idioma, tema ou lembrar configurações.  
Eles permanecem armazenados por mais tempo.  
O uso combinado garante segurança e melhor experiência.  

---

## Exercício 3  
*Pergunta:* Por que o cookie não está disponível na primeira execução?  

Ao executar o arquivo pela primeira vez, o cookie ainda não está disponível.  
Isso acontece porque ele foi apenas criado pelo servidor.  
A função que cria o cookie envia os dados ao navegador.  
Porém, o navegador ainda não retornou esse cookie.  
Por isso, ele não pode ser acessado imediatamente.  
Após atualizar a página, o cookie já foi salvo.  
Então o navegador o envia de volta ao servidor.  
Nesse momento, o valor do cookie pode ser exibido.  
Se o cookie for apagado, ele deixa de existir.  
E o processo volta ao estado inicial novamente.  

---

