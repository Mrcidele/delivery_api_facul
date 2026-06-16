# 🍔 API Delivery de Comida

Projeto desenvolvido para a disciplina de Integração de Sistemas de Software (Trabalho Final). O objetivo é fornecer uma API RESTful para o gerenciamento de produtos e pedidos de um sistema de delivery de comida. 

O projeto foi construído utilizando a **Arquitetura MVC**e não utiliza banco de dados relacional (sem SQL), armazenando os dados temporariamente em memória/cache local.

## 🚀 Tecnologias Utilizadas

* **Linguagem & Framework:** PHP 8.3+ com Laravel
* **Arquitetura:** MVC (Model-View-Controller) 
* **Integração Externa:** API ViaCEP (Busca de endereços) 
* **Persistência:** Cache local do Laravel (Sem SQL) 
* **Testes:** PHPUnit (equivalente ao Jest solicitado) 

## ⚙️ Regras de Negócio Implementadas

1.  **Validação de Itens:** Um pedido não pode ser criado sem itens. Caso ocorra, a API retorna `400 Bad Request` antes mesmo de consultar serviços externos.
2.  **Cálculo de Frete (ViaCEP):**
    * O CEP é consultado na API do ViaCEP (`GET https://viacep.com.br/ws/:cep/json/`).
    * Se o CEP for inválido ou não encontrado, retorna `400 Bad Request`.
    * **Taxa de Entrega:** Pedidos para a mesma cidade (Curitiba) custam **R$ 5,00**. Pedidos para outros municípios custam **R$ 15,00**.
    * O endereço completo (Logradouro, Bairro e Cidade) é salvo automaticamente no pedido.

## 📌 Endpoints da API

### Produtos
* `GET /produtos`: Lista todos os produtos cadastrados. 
* `POST /produtos`: Cadastra um novo produto (nome, preco, categoria, disponivel.

### Pedidos
* `GET /pedidos`: Lista todos os pedidos.
* `GET /pedidos/:id`: Retorna os detalhes de um pedido específico.
* `POST /pedidos`: Cria um novo pedido, calculando a taxa via CEP.
* `PUT /pedidos/:id/status`: Atualiza o status de um pedido.

### Eventos (M5)
* `POST /eventos/pedido-confirmado`: Simula a confirmação de um pedido. Retorna `202 Accepted` com a mensagem `"Pedido #{id} em processamento"`.

## 🛠️ Como Executar o Projeto

1. Clone o repositório.
2. Instale as dependências com o Composer:
   ```bash
   composer install

Copie o arquivo de ambiente e gere a chave da aplicação:
Bash
cp .env.example .env
php artisan key:generate

Inicie o servidor local:
Bash
php artisan serve
A API estará disponível em http://localhost:8000/api.
