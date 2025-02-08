# Projeto Futebol

Este é um projeto desenvolvido para uma entrevista de emprego. Ele utiliza a API-Football para exibir informações sobre o Campeonato Brasileiro de 2023. Devido ao uso da versão gratuita da API, apenas dados do ano de 2023 estão disponíveis. Para otimizar o uso da API e evitar sobrecarregar o plano gratuito, foi implementado um sistema de cache.

## Estrutura de Pastas

```shell
projeto-futebol/
├── .env
├── config.php
├── public/
│   └── index.php
├── readme.md
└── src/
    ├── cache/
    ├── Cache.php
    ├── Controllers/
    │   └── MatchController.php
    ├── Models/
    │   └── MatchModel.php
    ├── Router.php
    └── Views/
        └── home.php
```

Essa estrutura representa um projeto básico em PHP que provavelmente utiliza uma arquitetura MVC (Model-View-Controller) simplificada. Aqui está um detalhamento do que cada parte provavelmente representa:

* .env: Arquivo de variáveis de ambiente. Não deve ser incluído no controle de versão.
* config.php: Arquivo de configuração para conexões com o banco de dados, chaves de API, etc.
* public/: Diretório acessível pela web. index.php é o ponto de entrada para a aplicação.
* readme.md: Este arquivo, fornecendo informações sobre o projeto.
* src/: Diretório de código fonte.
* cache/: Diretório para dados em cache (provavelmente arquivos JSON neste caso).
* Cache.php: Classe para lidar com o cache.
* Controllers/: Contém classes de controlador (por exemplo, MatchController.php provavelmente lida com requisições relacionadas a partidas).
* Models/: Contém classes de modelo (por exemplo, MatchModel.php provavelmente interage com o banco de dados para dados de partidas).
* Router.php: Lida com o roteamento de requisições para os controladores apropriados.
* Views/: Contém templates de visualização (por exemplo, home.php provavelmente exibe a página inicial).


## Configuração e Execução

1. Clone o repositório para sua máquina local:
    ```sh
    git clone <URL_DO_REPOSITORIO>
    ```

2. Navegue até o diretório do projeto:
    ```sh
    cd projeto-futebol
    ```

3. Certifique-se de ter o PHP instalado em sua máquina. Você pode verificar a instalação do PHP com o comando:
    ```sh
    php -v
    ```

4. Crie um arquivo [.env](http://_vscodecontentref_/6) na raiz do projeto com as seguintes variáveis de ambiente:
    ```properties
    API_URL=https://v3.football.api-sports.io
    API_KEY=17fc0f4264cbee7596fc3bc9b5c5ec2b
    CHAMPIONSHIP_ID=71
    SEASON=2023
    ```

5. Inicie o servidor PHP embutido:
    ```sh
    php -S localhost:8000 -t public
    ```

6. Abra seu navegador e acesse `http://localhost:8000` para visualizar o projeto em execução.

## API Utilizada

Este projeto utiliza a [API-Football](https://www.api-football.com/) para obter dados sobre o Campeonato Brasileiro de 2023. A versão gratuita da API foi utilizada, o que limita os dados disponíveis ao ano de 2023.

## Sistema de Cache

Para otimizar o uso da API e evitar exceder os limites do plano gratuito, foi implementado um sistema de cache. As respostas da API são armazenadas em arquivos JSON na pasta [cache](http://_vscodecontentref_/7) e são reutilizadas por um período de 24 horas.

## Contato

Desenvolvido por [César Farkas](https://github.com/cesarfarkas).
