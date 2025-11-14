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

## Ambiente via Docker (recomendado)

1. Copie o `.env` caso ainda nao exista:
   ```bash
   cp .env.example .env
   ```
2. Ajuste as variaveis de banco para os containers (host `db`, usuario `andre`, senha `secret`):
   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=db
   DB_PORT=3306
   DB_DATABASE=andre_carros
   DB_USERNAME=andre
   DB_PASSWORD=secret
   ```
3. Suba os servicos:
   ```bash
   docker compose up --build
   ```
   O entrypoint instala dependencias (Composer/NPM), gera chave, executa `npm run build` e aplica as migrations automaticamente assim que o MySQL responder (incluindo a tabela `sessions`).
4. Rode os seeders (opcional, caso queira dados demo):
   ```bash
   docker compose run --rm app php artisan db:seed
   ```
5. A aplicacao ficara disponivel em `http://localhost:8000` e o MySQL exposto em `localhost:3307`.

Para encerrar:
```bash
docker compose down
```

## Ambiente manual (fallback)

1. Instale dependencias:
   ```bash
   composer install
   npm install
   npm run build   # ou npm run dev -- --host para desenvolvimento
   ```
2. Configure o `.env` apontando para o seu MySQL local:
   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=andre_carros
   DB_USERNAME=root
   DB_PASSWORD=root
   ```
3. Execute:
   ```bash
   php artisan migrate --seed
   php artisan serve
   ```

## Acesso administrativo

- URL: `http://127.0.0.1:8000/login`
- Usuario: `admin@andrecarros.com`
- Senha: `admin123`

> O cadastro publico permanece desabilitado. Para novos administradores utilize seeders ou `php artisan tinker`.

## Scripts uteis

- `npm run dev` – recompila assets em modo watch (Vite).
- `npm run build` – gera assets otimizados.
- `php artisan migrate:fresh --seed` – recria o banco do zero.
- `docker compose run --rm app php artisan test` – executa testes dentro do container.

## Estrutura de dados

- `brands`, `car_models`, `colors` – catalogos basicos.
- `vehicles` – anuncio com referencias a marca, modelo, cor, preco, descricao e foto principal.
- `vehicle_photos` – galeria com indicador da imagem primaria.

## Contato

Dúvidas ou sugestoes? `contato@andrecarros.com` ou abra uma issue mencionando **andreCarros**.
