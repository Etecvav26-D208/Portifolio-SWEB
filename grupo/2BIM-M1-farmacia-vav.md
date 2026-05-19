# 💊 Farmácia VAV

Sistema de gerenciamento de estoque desenvolvido com **PHP + PDO + MySQL**, como atividade prática da disciplina de Desenvolvimento Web da Etec.
Link
[Entre no repositório: farmacia-vav](https://github.com/NatN21/farmacia-vav)

O projeto aplica conceitos de:

- CRUD completo
- PDO (PHP Data Objects)
- Segurança com Prepared Statements
- Modularização com `require_once`
- Responsividade Mobile First
- Organização de projeto em equipe
- Design utilizando a regra 60-30-10

---

# 🚀 Tecnologias Utilizadas

- PHP
- MySQL
- PDO
- HTML5
- CSS3
- XAMPP
- Git & GitHub

---

# 📂 Estrutura do Projeto 

```text
farmacia-vav/
│
├── config/
│   └── conexao.php
│
├── includes/
│   ├── header.php
│   └── footer.php
│
├── css/
│   └── style.css
│
├── index.php
├── cadastro.php
├── editar.php
├── excluir.php
│
└── database.sql
```

---

# ⚙️ Funcionalidades

✅ Cadastro de produtos  
✅ Listagem de estoque  
✅ Edição de produtos  
✅ Exclusão de registros  
✅ Layout responsivo  
✅ Integração com banco de dados  

---

# 🛡️ Segurança

O sistema utiliza **PDO com `prepare()` e `execute()`**, evitando vulnerabilidades como SQL Injection.

---

# 📱 Responsividade

O projeto foi desenvolvido seguindo a abordagem **Mobile First**, garantindo boa usabilidade em celulares e computadores.

---

# 👨‍💻 Equipe

Projeto desenvolvido em grupo para fins educacionais.
Grupo: 
- Maria Eduarda 
- Mariana Rasmussen 
- Natan Costa (gerente) 
- Pietro Dopp 

---

# 📌 Observações

Para executar o projeto:

1. Inicie Apache e MySQL no XAMPP
2. Importe o arquivo `database.sql`
3. Coloque a pasta do projeto dentro de `htdocs`
4. Acesse:

```text
http://localhost/farmacia-vav
```

---

> “Grandes sistemas nascem de pequenas estruturas bem organizadas.”
