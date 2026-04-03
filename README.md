
# Docker: Cluster com Load Balancer, PHP e MySQL

Projeto evoluído a partir da Live Coding "Docker: Utilização prática no cenário de Microsserviços" da Digital Innovation One (Instrutor: Denilson Bonatti).

## 🚀 Melhorias aplicadas neste fork
Este projeto foi refatorado para refletir práticas reais de mercado:

* Orquestração com Docker Compose: Criação de todo o ambiente com um único comando.

* Load Balancing Inteligente: O Nginx agora utiliza o DNS embutido do Docker Compose para distribuir o tráfego, eliminando a necessidade de IPs estáticos no arquivo nginx.conf.

* Escalabilidade Horizontal: Configuração otimizada para subir múltiplas instâncias da aplicação com a tag --scale.

* Segurança: Remoção de credenciais de banco de dados do código fonte (index.php), utilizando Variáveis de Ambiente.

* Refatoração PHP: Implementação de Prepared Statements para prevenir SQL Injection, layout visual melhorado e funcionalidade de leitura (SELECT) para visualização em tempo real de qual container inseriu o dado.

## 📁 Estrutura de Diretórios
```bash
meu-projeto-docker/
├── docker-compose.yml      # Orquestrador principal
├── README.md               # Documentação do projeto
│
├── app/                    # Diretório da aplicação PHP
│   ├── Dockerfile          # Instala dependências do PHP Apache
│   └── index.php           # Código fonte da aplicação
│
├── db/                     # Diretório do Banco de Dados
│   └── banco.sql           # Script de criação da tabela (roda automaticamente)
│
└── nginx/                  # Diretório do Load Balancer
    ├── Dockerfile          # Prepara a imagem do Nginx
    └── nginx.conf          # Configuração de rotas e balanceamento

```
## 🛠️ Como executar o projeto

1. Certifique-se de ter o Docker e o Docker Compose instalados em sua máquina.

2. Clone este repositório.

3. No terminal, navegue até a raiz do projeto e execute:
```bash
 # Para subir o banco, o load balancer e 3 instâncias do servidor PHP simultaneamente
docker-compose up -d --scale app=3
```
4. Acesse em seu navegador: http://localhost:8080

5. Atualize a página várias vezes (F5). Você notará no painel que o "Servidor PHP (Container ID)" irá mudar, provando que o Nginx está balanceando a carga entre as 3 instâncias que criamos!

## 🧹 Como parar e limpar os containers
```bash
docker-compose down -v
```