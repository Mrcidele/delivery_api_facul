# 🍔 API Delivery de Comida

Projeto desenvolvido para a disciplina de Integração de Sistemas de Software (Trabalho Final). O objetivo é fornecer uma API RESTful para o gerenciamento de produtos e pedidos de um sistema de delivery de comida. 

[cite_start]O projeto foi construído utilizando a **Arquitetura MVC** [cite: 9] [cite_start]e não utiliza banco de dados relacional (sem SQL)[cite: 47], armazenando os dados temporariamente em memória/cache local.

## 🚀 Tecnologias Utilizadas

* **Linguagem & Framework:** PHP 8.3+ com Laravel
* [cite_start]**Arquitetura:** MVC (Model-View-Controller) [cite: 9]
* [cite_start]**Integração Externa:** API ViaCEP (Busca de endereços) [cite: 25]
* [cite_start]**Persistência:** Cache local do Laravel (Sem SQL) [cite: 47]
* [cite_start]**Testes:** PHPUnit (equivalente ao Jest solicitado) [cite: 34]

## ⚙️ Regras de Negócio Implementadas

1.  **Validação de Itens:** Um pedido não pode ser criado sem itens. [cite_start]Caso ocorra, a API retorna `400 Bad Request` antes mesmo de consultar serviços externos[cite: 24, 45].
2.  **Cálculo de Frete (ViaCEP):**
    * [cite_start]O CEP é consultado na API do ViaCEP (`GET https://viacep.com.br/ws/:cep/json/`)[cite: 29].
    * [cite_start]Se o CEP for inválido ou não encontrado, retorna `400 Bad Request`[cite: 24, 28, 46].
    * [cite_start]**Taxa de Entrega:** Pedidos para a mesma cidade (Curitiba) custam **R$ 5,00**[cite: 23]. [cite_start]Pedidos para outros municípios custam **R$ 15,00**[cite: 24].
    * [cite_start]O endereço completo (Logradouro, Bairro e Cidade) é salvo automaticamente no pedido[cite: 27].

## 📌 Endpoints da API

### Produtos
* [cite_start]`GET /produtos`: Lista todos os produtos cadastrados[cite: 10].
* [cite_start]`POST /produtos`: Cadastra um novo produto (nome, preco, categoria, disponivel)[cite: 5, 11].

### Pedidos
* [cite_start]`GET /pedidos`: Lista todos os pedidos[cite: 11].
* [cite_start]`GET /pedidos/:id`: Retorna os detalhes de um pedido específico[cite: 14].
* [cite_start]`POST /pedidos`: Cria um novo pedido, calculando a taxa via CEP[cite: 12].
* [cite_start]`PUT /pedidos/:id/status`: Atualiza o status de um pedido[cite: 13].

### Eventos (M5)
* [cite_start]`POST /eventos/pedido-confirmado`: Simula a confirmação de um pedido[cite: 30, 31]. [cite_start]Retorna `202 Accepted` com a mensagem `"Pedido #{id} em processamento"`[cite: 33, 44].

## 🛠️ Como Executar o Projeto

1. Clone o repositório.
2. Instale as dependências com o Composer:
   ```bash
   composer install
