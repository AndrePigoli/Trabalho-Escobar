README.md — versão atualizada (em código)
# andreCarros

Aplicacao Laravel para a vitrine digital da revenda **andreCarros**, agora com interface renovada, dados em tempo real e ambiente totalmente conteinerizado. O foco continua sendo a curadoria humana de seminovos premium, mas com processos 100% digitais (laudos, assinatura e entrega).

## Novidades 2025

- **Front-end reestilizado** com hero interativo, cards em glassmorphism, CTAs de agendamento e secao dedicada a diferenciais e contato.
- **Back-end ajustado**: view model agrega estatisticas globais do estoque e alimenta o front com atividades recentes sem onerar as blades.
- **Infra pronta para Docker** (`docker-compose.yml` + `docker/Dockerfile`) com PHP 8.2, Node 18 e MySQL 8; basta subir os servicos para iniciar.

## Stack principal

- PHP 8.2 + Laravel 12
- MySQL 8
- Tailwind + Vite
- Breeze (Blade) para autenticacao

---

## Ambiente via Docker (recomendado)

1. Copie o `.env` caso ainda nao exista:
   ```bash
   cp .env.example .env


## Ajuste as variaveis de banco para os containers (host db, usuario andre, senha secret):

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=andre_carros
DB_USERNAME=andre
DB_PASSWORD=secret


## Suba os servicos:

docker compose up --build


O entrypoint instala dependencias (Composer/NPM), gera chave, executa npm run build e aplica as migrations automaticamente assim que o MySQL responder (incluindo a tabela sessions).

## Rode os seeders — IMPORTANTE para conseguir acessar o admin e ver carros na home:

## docker compose run --rm app php artisan migrate --seed

## Por que isso é necessário?

As seeds não são aplicadas no seu Windows, porque a aplicação Laravel não está rodando no Windows, mas sim dentro do container do Docker.

Se você rodar php artisan migrate --seed fora do container, o comando não atinge o MySQL que está rodando dentro do serviço db do Docker.

Portanto, você precisa rodar o comando dentro do container app, que é onde o Laravel realmente está executando.
## (você pode rodar também no exec dentro do container(AndreCarros-app) do docker desktop o comando: php artisan migrate --seed)

O que acontece se não rodar esse comando?

Você não conseguirá logar com o usuário admin, pois ele só existe no seeder.

Nenhum carro aparecerá na Home ou na área admin.

O banco virá "zerado", já que a imagem MySQL inicia sem dados e só é povoada quando a seed roda no container.

A aplicacao ficara disponivel em http://localhost:8000 e o MySQL exposto em localhost:3307.

Para encerrar:

docker compose down

Ambiente manual (fallback)

Instale dependencias:

composer install
npm install
npm run build   # ou npm run dev -- --host para desenvolvimento


## Configure o .env apontando para o seu MySQL local:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=andre_carros
DB_USERNAME=root
DB_PASSWORD=root


Execute:

php artisan migrate --seed
php artisan serve

Acesso administrativo

URL: http://127.0.0.1:8000/login

Usuario: admin@andrecarros.com

Senha: admin123

O cadastro publico permanece desabilitado. Para novos administradores utilize seeders ou php artisan tinker.

Scripts uteis

npm run dev – recompila assets em modo watch (Vite).

npm run build – gera assets otimizados.

php artisan migrate:fresh --seed – recria o banco do zero.

docker compose run --rm app php artisan test – executa testes dentro do container.

Estrutura de dados

brands, car_models, colors – catalogos basicos.

vehicles – anuncio com referencias a marca, modelo, cor, preco, descricao e foto principal.

vehicle_photos – galeria com indicador da imagem primaria.